<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Constants\UserConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserUsecase extends Usecase
{
    private const DEFAULT_PASSWORD = 'asdasd';

    public function __construct()
    {
    }

    public function getAll(array $filterData = []): array
    {
        try {
            $data = DB::table(DatabaseConst::USER)
                ->whereNull('deleted_at')
                ->when(Auth::user()->school_id, function ($query, $schoolId) {
                    return $query->where('school_id', $schoolId)->where('access_type', UserConst::ADMIN_SEKOLAH);
                }, function ($query) {
                    return $query->whereIn('access_type', [UserConst::SUPER_ADMIN, UserConst::ADMIN_SEKOLAH]);
                })
                ->when($filterData['keywords'] ?? false, function ($query, $keywords) {
                    return $query->where(function ($q) use ($keywords) {
                        $q->where('name', 'like', '%' . $keywords . '%')
                            ->orWhere('email', 'like', '%' . $keywords . '%');
                    });
                })
                ->when($filterData['access_type'] ?? false, function ($query, $accessType) {
                    if ($accessType !== 'all') {
                        return $query->where('access_type', $accessType);
                    }
                })
                ->when($filterData['school_id'] ?? false, function ($query, $schoolId) {
                    if ($schoolId !== 'all') {
                        return $query->where('school_id', $schoolId);
                    }
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            if (!empty($filterData)) {
                $data->appends($filterData);
            }

            return Response::buildSuccess(
                [
                    'list' => $data,
                ],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function getByID(int $id): array
    {
        try {
            $data = DB::table(DatabaseConst::USER)
                ->whereNull('deleted_at')
                ->where('id', $id)
                ->when(Auth::user()->school_id, function ($query, $schoolId) {
                    return $query->where('school_id', $schoolId)->where('access_type', UserConst::ADMIN_SEKOLAH);
                }, function ($query) {
                    return $query->whereIn('access_type', [UserConst::SUPER_ADMIN, UserConst::ADMIN_SEKOLAH]);
                })
                ->first();

            return Response::buildSuccess(
                data: collect($data)->toArray()
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function register(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $validator->validate();

        DB::beginTransaction();

        try {
            $userID = DB::table(DatabaseConst::USER)->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'access_type' => 2,
                'school_id' => null,
                'is_active' => 1,
                'created_at' => now(),
            ]);

            DB::commit();

            return Response::buildSuccess(
                data: [
                    'user_id' => $userID,
                ],
                message: 'Registrasi akun berhasil'
            );
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $validator->validate();

        DB::beginTransaction();

        try {
            $accessType = $data->access_type ?? 2;
            $schoolId = Auth::user()->school_id;

            if (Auth::user()->access_type == UserConst::SUPER_ADMIN) {
                $accessType = $data->access_type;
                $schoolId = ($accessType == UserConst::SUPER_ADMIN) ? null : $data->school_id;
            }

            $userID = DB::table(DatabaseConst::USER)->insertGetId([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'access_type' => $accessType,
                'school_id' => $schoolId,
                'is_active' => 1,
                'created_at' => now(),
            ]);

            DB::commit();

            return Response::buildSuccess(
                data: [
                    'user_id' => $userID,
                ],
                message: 'Tambah User berhasil'
            );
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function update(Request $data, int $id): array|Exception
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
        ]);

        $validator->validate();

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
            'updated_by' => Auth::user()?->id,
            'updated_at' => now(),
        ];

        if (Auth::user()->access_type == UserConst::SUPER_ADMIN) {
            $update['access_type'] = $data['access_type'];
            $update['school_id'] = ($data['access_type'] == UserConst::SUPER_ADMIN) ? null : $data['school_id'];
        }

        DB::beginTransaction();

        try {
            DB::table(DatabaseConst::USER)
                ->where('id', $id)
                ->update($update);

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();

        try {
            $delete = DB::table(DatabaseConst::USER)
                ->where('id', $id)
                ->update([
                    'deleted_by' => Auth::user()?->id,
                    'deleted_at' => now(),
                ]);

            if (!$delete) {
                DB::rollback();
                throw new Exception('FAILED DELETE DATA');
            }

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function changePassword(array $data): array
    {
        $userID = Auth::user()?->id;

        $validator = Validator::make($data, [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:6', 'different:current_password'],
        ]);

        $customAttributes = [
            'current_password' => 'Password Lama',
            'password' => 'Password Baru',
        ];
        $validator->setAttributeNames($customAttributes);
        $validator->validate();

        DB::beginTransaction();

        try {
            $locked = DB::table(DatabaseConst::USER)
                ->where('id', $userID)
                ->whereNull('deleted_at')
                ->lockForUpdate()
                ->first(['id']);

            if (!$locked) {
                DB::rollback();

                throw new Exception('FAILED LOCKED DATA');
            }

            DB::table(DatabaseConst::USER)
                ->where('id', $userID)
                ->update([
                    'password' => Hash::make($data['password']),
                    'updated_by' => $userID,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function resetPassword(int $id): array
    {

        DB::beginTransaction();

        try {
            DB::table(DatabaseConst::USER)
                ->where('id', $id)
                ->update([
                    'password' => Hash::make('asdasd'),
                    'updated_by' => Auth::user()?->id,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return Response::buildSuccess(
                message: 'Password berhasil direset'
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }
}