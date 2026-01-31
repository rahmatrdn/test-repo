    public function addQuestions(Request $data, int $quizId): array
    {
    $validator = Validator::make($data->all(), [
    'questions' => 'required|array|min:1',
    'questions.*.question' => 'required|string',
    'questions.*.correct_answer' => 'required|in:A,B,C,D,E',
    ]);

    $validator->validate();

    DB::beginTransaction();
    try {
    $userId = Auth::user()?->id;

    if (! $userId) {
    throw new Exception('User not authenticated');
    }

    // Verify quiz exists and user has permission
    $quiz = DB::table(DatabaseConst::QUIZ)
    ->where('id', $quizId)
    ->whereNull('deleted_at')
    ->first();

    if (!$quiz) {
    throw new Exception('Quiz not found');
    }

    // Insert questions and options
    foreach ($data->questions as $questionData) {
    $questionId = DB::table(DatabaseConst::QUIZ_QUESTION)->insertGetId([
    'quiz_id' => $quizId,
    'question' => $questionData['question'],
    'created_by' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
    ]);

    // Insert options (A-E)
    $options = ['A', 'B', 'C', 'D', 'E'];
    foreach ($options as $option) {
    $optionKey = 'option_'.strtolower($option);

    // Only insert if option text is provided
    if (! empty($questionData[$optionKey])) {
    DB::table(DatabaseConst::QUIZ_OPTION)->insert([
    'question_id' => $questionId,
    'option_text' => $questionData[$optionKey],
    'is_correct' => $questionData['correct_answer'] === $option ? 1 : 0,
    'created_by' => $userId,
    'created_at' => now(),
    'updated_at' => now(),
    ]);
    }
    }
    }

    DB::commit();

    return Response::buildSuccessCreated();
    } catch (Exception $e) {
    DB::rollback();
    Log::error($e->getMessage(), ['method' => __METHOD__]);

    return Response::buildErrorService($e->getMessage());
    }
    }