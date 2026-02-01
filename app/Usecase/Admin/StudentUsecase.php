<?php

namespace App\Usecase\Admin;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentUsecase extends Usecase
{
    public function getAll(array $filterData = []): array
    {
        try {
            $schoolId = Auth::user()?->school_id;

            $query = DB::table(DatabaseConst::STUDENT . ' as s')
                ->join(DatabaseConst::USER . ' as u', 's.user_id', '=', 'u.id')
                ->join(DatabaseConst::CLASSROOM . ' as c', 's.classroom_id', '=', 'c.id')
                ->whereNull('s.deleted_at')
                ->where('s.school_id', $schoolId)
                ->select(
                    's.*',
                    'u.name',
                    'u.email',
                    'c.class_name',
                    'c.entry_year'
                )
                ->orderBy('s.created_at', 'desc');

            if (!empty($filterData['keywords'])) {
                $query->where('u.name', 'like', '%' . $filterData['keywords'] . '%');
            }

            if (!empty($filterData['classroom_id'])) {
                $query->where('s.classroom_id', $filterData['classroom_id']);
            }
            $data = empty($filterData['no_pagination'])
                ? $query->paginate(20)
                : $query->get();

            if (method_exists($data, 'appends')) {
                $data->appends($filterData);
            }


            if ($data instanceof AbstractPaginator) {
                $data->getCollection()->transform(function ($item) {
                    $grade = (now()->year - (int) $item->entry_year) + 10;
                    $item->display_class = $grade . ' ' . $item->class_name;
                    return $item;
                });
            } else {
                $data->transform(function ($item) {
                    $grade = (now()->year - (int) $item->entry_year) + 10;
                    $item->display_class = $grade . ' ' . $item->class_name;
                    return $item;
                });
            }

            return Response::buildSuccess(
                ['list' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }




    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $schoolId = Auth::user()?->school_id;
            $adminId = Auth::user()?->id;

            // 1. CREATE USER (SISWA)
            $userId = DB::table(DatabaseConst::USER)->insertGetId([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make('asdasd'),
                'access_type' => 4,
                'school_id' => $schoolId,
                'is_active' => 1,
                'created_at' => now(),
            ]);

            // 2. CREATE STUDENT
            DB::table(DatabaseConst::STUDENT)->insert([
                'school_id' => $schoolId,
                'user_id' => $userId,
                'classroom_id' => $data->classroom_id,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return Response::buildSuccessCreated();
        } catch (Exception $e) {
            DB::rollback();

            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function getById(int $id): array
    {
        try {
            $schoolId = Auth::user()?->school_id;

            $data = DB::table(DatabaseConst::STUDENT . ' as s')
                ->join(DatabaseConst::USER . ' as u', 's.user_id', '=', 'u.id')
                ->whereNull('s.deleted_at')
                ->where('s.school_id', $schoolId)
                ->where('s.id', $id)
                ->select(
                    's.*',
                    'u.name',
                    'u.email'
                )
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound('Data siswa tidak ditemukan');
            }

            return Response::buildSuccess(
                ['data' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function update(Request $data, int $id): array
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            // ambil student dulu
            $student = DB::table(DatabaseConst::STUDENT)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$student) {
                throw new Exception('Data siswa tidak ditemukan');
            }

            // 1. UPDATE USER
            DB::table(DatabaseConst::USER)
                ->where('id', $student->user_id)
                ->update([
                    'name' => $data->name,
                    'email' => $data->email,
                    'updated_at' => now(),
                ]);

            // 2. UPDATE STUDENT (PINDAH KELAS)
            DB::table(DatabaseConst::STUDENT)
                ->where('id', $id)
                ->update([
                    'classroom_id' => $data->classroom_id,
                    'updated_by' => Auth::user()?->id,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function resetPassword(int $id): array
    {
        DB::beginTransaction();
        try {
            $student = DB::table(DatabaseConst::STUDENT)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$student) {
                throw new Exception('Data siswa tidak ditemukan');
            }

            DB::table(DatabaseConst::USER)
                ->where('id', $student->user_id)
                ->update([
                    'password' => Hash::make('asdasd'),
                    'updated_at' => now(),
                ]);

            DB::commit();
            return Response::buildSuccess(
                message: 'Password berhasil diperbarui'
            );
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            DB::table(DatabaseConst::STUDENT)
                ->where('id', $id)
                ->update([
                    'deleted_by' => Auth::user()?->id,
                    'deleted_at' => now(),
                ]);

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }
}
