<?php

namespace App\Usecase\Teacher;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use App\Jobs\RunLearningModuleSummarizer;
use App\Usecase\Usecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LearningModulesUsecase extends Usecase
{

    public function getAll(array $filterData = []): array
    {
        try {
            $user = Auth::user();
            if (!$user) {
                throw new Exception('User not authenticated');
            }

            $query = DB::table(DatabaseConst::LEARNING_MODULE . ' as lm')
                ->join(DatabaseConst::SUBJECT . ' as s', 'lm.subject_id', '=', 's.id')
                ->whereNull('lm.deleted_at')
                ->select(
                    'lm.id',
                    'lm.title',
                    'lm.classroom',
                    'lm.file_path',
                    'lm.summary',
                    's.name as subject_name',
                    'lm.created_at',
                )
                ->orderBy('lm.created_at', 'desc');

            if ($user->access_type == 4) {
                $query->where('lm.school_id', $user->school_id);
            } else {
                $query->where('lm.created_by', $user->id);
            }

            if (!empty($filterData['keywords'])) {
                $query->where('lm.title', 'like', '%' . $filterData['keywords'] . '%')->orWhere('s.name', 'like', '%' . $filterData['keywords'] . '%');
            }

            if(!empty($filterData['subject_id']) && $filterData['subject_id'] != 'all') {
                $query->where('lm.subject_id', $filterData['subject_id']);
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
            'title' => 'required|string|max:255',
            'subject_id' => 'required|integer|exists:subjects,id',
            'classroom' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,webp,png,jpg,jpeg|max:20480',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $userId = Auth::user()?->id;
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            $file = $data->file('file');

            $extension = $file->getClientOriginalExtension();

            $subject = DB::table(DatabaseConst::SUBJECT)
                ->where('id', $data->subject_id)
                ->first();
            $subjectName = $subject ? str_replace(' ', '_', $subject->name) : 'unknown';

            $fileName = date('Ymd') . '-' . $subjectName . '-' . str_replace(' ', '_', $data->title) . '.' . $extension;

            $filePath = Storage::disk('public')->putFileAs(
                'learning_modules',
                $file,
                $fileName
            );

            $moduleId = DB::table(DatabaseConst::LEARNING_MODULE)->insertGetId([
                'title' => $data->title,
                'subject_id' => $data->subject_id,
                'classroom' => $data->classroom,
                'file_path' => $filePath,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
                'school_id' => Auth::user()?->school_id,
            ]);

            DB::commit();

            // Dispatch job queue for summarization
            RunLearningModuleSummarizer::dispatch(
                $filePath,
                $file->getClientOriginalName(),
                $file->getMimeType(),
                $moduleId,
                $userId
            );

            Log::info('Learning module created and summarization job dispatched', [
                'module_id' => $moduleId,
                'file' => $fileName,
                'user_id' => $userId
            ]);

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
            $data = DB::table(DatabaseConst::LEARNING_MODULE . ' as lm')
                ->join(DatabaseConst::SUBJECT . ' as s', 'lm.subject_id', '=', 's.id')
                ->join(DatabaseConst::USER . ' as u', 'lm.created_by', '=', 'u.id')
                ->where('lm.id', $id)
                ->whereNull('lm.deleted_at')
                ->select(
                    'lm.id',
                    'lm.title',
                    'lm.classroom',
                    'lm.file_path',
                    's.name as subject_name',
                    'u.name as created_by_name',
                    'lm.created_at',
                    'lm.updated_at',
                )
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound('Data modul pembelajaran tidak ditemukan');
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
            'title' => 'required|string|max:255',
            'subject_id' => 'required|integer|exists:subjects,id',
            'classroom' => 'required|string|max:100',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('id', $id)
                ->update([
                    'title' => $data->title,
                    'subject_id' => $data->subject_id,
                    'classroom' => $data->classroom,
                    'file_path' => $data->file ? $data->file->store('learning_modules') : DB::raw('file_path'),
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

    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('id', $id)
                ->update([
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
