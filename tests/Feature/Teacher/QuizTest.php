<?php

use App\Constants\DatabaseConst;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create test user (teacher)
    $this->user = DB::table('users')->insertGetId([
        'name' => 'Test Teacher',
        'email' => 'teacher@test.com',
        'password' => bcrypt('password'),
        'access_type' => 3, // Teacher
        'school_id' => 1,
        'is_active' => 1,
        'created_at' => now(),
    ]);

    // Create school
    DB::table('schools')->insert([
        'id' => 1,
        'school_name' => 'Test School',
        'school_address' => 'Test Address',
        'created_at' => now(),
    ]);

    $this->actingAs((object) [
        'id' => $this->user,
        'name' => 'Test Teacher',
        'email' => 'teacher@test.com',
        'access_type' => 3,
        'school_id' => 1,
    ]);
});

test('quiz index page loads successfully', function () {
    $response = $this->get(route('teacher.quiz.index'));

    $response->assertSuccessful();
    $response->assertViewIs('_teacher.quiz.index');
});

test('quiz create page loads successfully', function () {
    $response = $this->get(route('teacher.quiz.add'));

    $response->assertSuccessful();
    $response->assertViewIs('_teacher.quiz.add');
});

test('can create quiz with questions and options', function () {
    $quizData = [
        'name' => 'Test Quiz',
        'description' => 'Test quiz description',
        'duration' => 60,
        'questions' => [
            1 => [
                'question' => 'What is 2+2?',
                'option_a' => '3',
                'option_b' => '4',
                'option_c' => '5',
                'correct_answer' => 'B',
            ],
            2 => [
                'question' => 'What is the capital of France?',
                'option_a' => 'London',
                'option_b' => 'Berlin',
                'option_c' => 'Paris',
                'correct_answer' => 'C',
            ],
        ],
    ];

    $response = $this->post(route('teacher.quiz.store'), $quizData);

    $response->assertRedirect(route('teacher.quiz.index'));
    $response->assertSessionHas('success');

    // Verify quiz created
    $this->assertDatabaseHas(DatabaseConst::QUIZ, [
        'quiz_name' => 'Test Quiz',
        'description' => 'Test quiz description',
        'quiz_time' => 60,
    ]);

    // Verify questions created
    $quiz = DB::table(DatabaseConst::QUIZ)->where('quiz_name', 'Test Quiz')->first();
    $questions = DB::table(DatabaseConst::QUIZ_QUESTION)->where('quiz_id', $quiz->id)->get();

    expect($questions)->toHaveCount(2);

    // Verify options created
    foreach ($questions as $question) {
        $options = DB::table(DatabaseConst::QUIZ_OPTION)->where('question_id', $question->id)->get();
        expect($options->count())->toBeGreaterThan(0);
    }
});

test('quiz validation requires name and questions', function () {
    $response = $this->post(route('teacher.quiz.store'), [
        'description' => 'Test without name',
    ]);

    $response->assertSessionHasErrors(['name', 'questions']);
});

test('can view quiz detail with questions', function () {
    // Create quiz first
    $quizId = DB::table(DatabaseConst::QUIZ)->insertGetId([
        'quiz_name' => 'Detail Test Quiz',
        'description' => 'Test description',
        'quiz_code' => 'TEST1234',
        'quiz_time' => 60,
        'school_id' => 1,
        'created_by' => $this->user,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->get(route('teacher.quiz.detail', $quizId));

    $response->assertSuccessful();
    $response->assertViewIs('_teacher.quiz.detail');
    $response->assertViewHas('data');
});

test('can delete quiz', function () {
    // Create quiz
    $quizId = DB::table(DatabaseConst::QUIZ)->insertGetId([
        'quiz_name' => 'Quiz to Delete',
        'description' => 'Will be deleted',
        'quiz_code' => 'DEL12345',
        'quiz_time' => 60,
        'school_id' => 1,
        'created_by' => $this->user,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->delete(route('teacher.quiz.delete', $quizId));

    $response->assertRedirect(route('teacher.quiz.index'));
    $response->assertSessionHas('success');

    // Verify soft delete
    $quiz = DB::table(DatabaseConst::QUIZ)->where('id', $quizId)->first();
    expect($quiz->deleted_at)->not->toBeNull();
});
