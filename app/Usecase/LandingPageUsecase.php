<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class LandingPageUsecase
{
    public function getLearningModulFilter(int $jenjang, int $kelas, ?int $mapel = null) {
        try {
            $query = DB::table(DatabaseConst::LEARNING_MODULE . ' as lm')
                ->join(DatabaseConst::SCHOOL . ' as s', 's.id', '=', 'lm.school_id')
                ->leftJoin(DatabaseConst::SUBJECT . ' as sb', 'sb.id', '=', 'lm.subject_id')

                // soft delete safety
                ->whereNull('lm.deleted_at')
                ->whereNull('s.deleted_at')

                // 🔎 FILTER WAJIB
                ->where('s.grade', $jenjang)
                ->where('lm.classroom', $kelas)

                // 🔥 FILTER OPSIONAL MAPEL
                ->when($mapel, function ($q, $mapel) {
                    $q->where('lm.subject_id', $mapel);
                })

                ->select([
                    'lm.id',
                    'lm.title',
                    'lm.summary',
                    'lm.file_path',
                    'lm.total_download',
                    'lm.created_at',

                    'lm.classroom',
                    'lm.subject_id',

                    's.id as school_id',
                    's.school_name',
                    's.grade',

                    'sb.name',
                ])
                ->orderBy('lm.created_at', 'desc');

            $data = $query->paginate(10);

            return Response::buildSuccess(
                ['list' => $data],
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

    public function getAllSubject(array $filterData = [])
    {
        try {
            $query = DB::table(DatabaseConst::SUBJECT . ' as s')
                ->whereNull('s.deleted_at')
                ->select([
                    's.id',
                    's.name'
                ])
                ->when($filterData['keywords'] ?? false, function ($query, $keywords) {
                    $query->where(function ($q) use ($keywords) {
                        $q->where('s.subject_name', 'like', '%' . $keywords . '%')
                        ->orWhere('s.description', 'like', '%' . $keywords . '%');
                    });
                })
                ->orderBy('s.created_at', 'desc');

            if (! empty($filterData['no_pagination'])) {
                $data = $query->get();
            } else {
                $data = $query->paginate(20);

                if (! empty($filterData)) {
                    $data->appends($filterData);
                }
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

    public function getLearningModulById(string $id)
    {
        try {
            $data = DB::table(DatabaseConst::LEARNING_MODULE . ' as lm')
                ->join(DatabaseConst::SCHOOL . ' as s', 's.id', '=', 'lm.school_id')
                ->leftJoin(DatabaseConst::SUBJECT . ' as sub', 'sub.id', '=', 'lm.subject_id')
                ->where('lm.id', $id)
                ->whereNull('lm.deleted_at')
                ->select([
                    'lm.id',
                    'lm.title',
                    'lm.summary',
                    'lm.grade',
                    'lm.classroom',
                    'lm.subject_id',
                    'sub.name as subject_name',
                    'lm.school_id',
                    's.school_name',
                    'lm.file_path',
                    'lm.created_at',
                ])
                ->first();

            if (! $data) {
                return Response::buildErrorService(
                    'Materi tidak ditemukan',
                    ResponseConst::HTTP_NOT_FOUND
                );
            }

            return Response::buildSuccess(
                [
                    'detail' => $data,
                ],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                    'id' => $id,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    
}
