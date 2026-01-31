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

class TeacherUsecase extends Usecase
{

    public function getAll(array $filterData = []): array
    {
        try {
            $schoolId = Auth::user()?->school_id;

            $query = DB::table(DatabaseConst::TEACHER . ' as t')
                ->join(DatabaseConst::USER . ' as u', 't.user_id', '=', 'u.id')
                ->whereNull('t.deleted_at')
                ->where('t.school_id', $schoolId)
                ->select(
                    't.id',
                    't.created_at',
                    'u.name',
                    'u.email'
                )
                ->orderBy('t.created_at', 'desc');

            if (!empty($filterData['keywords'])) {
                $query->where('u.name', 'like', '%' . $filterData['keywords'] . '%')->orWhere('u.email', 'like', '%' . $filterData['keywords'] . '%');
            }

            $data = $query->paginate(20);

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
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $schoolId = Auth::user()?->school_id;
            $adminId = Auth::user()?->id;

            $userId = DB::table(DatabaseConst::USER)->insertGetId([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make('asdasd'),
                'access_type' => 3,
                'school_id' => $schoolId,
                'is_active' => 1,
                'created_at' => now(),
            ]);

            DB::table(DatabaseConst::TEACHER)->insert([
                'school_id' => $schoolId,
                'user_id' => $userId,
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

            $data = DB::table(DatabaseConst::TEACHER . ' as t')
                ->join(DatabaseConst::USER . ' as u', 't.user_id', '=', 'u.id')
                ->where('t.id', $id)
                ->where('t.school_id', $schoolId)
                ->whereNull('t.deleted_at')
                ->select(
                    't.id',
                    't.school_id',
                    't.user_id',
                    'u.name',
                    'u.email'
                )
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound('Data guru tidak ditemukan');
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
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $teacher = DB::table(DatabaseConst::TEACHER)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$teacher) {
                throw new Exception('Data guru tidak ditemukan');
            }

            // UPDATE USER
            DB::table(DatabaseConst::USER)
                ->where('id', $teacher->user_id)
                ->update([
                    'name' => $data->name,
                    'email' => $data->email,
                    'updated_at' => now(),
                ]);

            // UPDATE TEACHER (AUDIT)
            DB::table(DatabaseConst::TEACHER)
                ->where('id', $id)
                ->update([
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
            $teacher = DB::table(DatabaseConst::TEACHER)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$teacher) {
                throw new Exception('Data guru tidak ditemukan');
            }

            DB::table(DatabaseConst::USER)
                ->where('id', $teacher->user_id)
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
            $teacher = DB::table(DatabaseConst::TEACHER)
                ->where('id', $id)
                ->first(); 

            if ($teacher) {
                DB::table(DatabaseConst::TEACHER)
                    ->where('id', $id)
                    ->update([
                        'deleted_by' => Auth::id(),
                        'deleted_at' => now(),
                    ]);

                DB::table(DatabaseConst::USER)
                    ->where('id', $teacher->user_id)
                    ->update([
                        'deleted_by' => Auth::id(),
                        'deleted_at' => now(),
                    ]);
            }

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
