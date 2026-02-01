<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SchoolController as AdminSchoolController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TaskCategoryController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\LearningModulesController as studentLearningModulesController;
use App\Http\Controllers\superAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Student\IntractiveQuiz as StudentQuizController;
use App\Http\Controllers\superAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\superAdmin\PromptImageController;
use App\Http\Controllers\superAdmin\SchoolController;
use App\Http\Controllers\superAdmin\SubjectController;
use App\Http\Controllers\superAdmin\TextPromptController;
use App\Http\Controllers\Teacher\AITools\IlustrationController;
use App\Http\Controllers\Teacher\AITools\MateriAjarController;
use App\Http\Controllers\Teacher\AITools\QuizGeneratorController;
use App\Http\Controllers\Teacher\LearningModulesController;
use App\Http\Controllers\Teacher\QuizController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\ToolsController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/get-materi/{jenjang}/{kelas}/{mapel}', [HomeController::class, 'get_materi'])->name('get_materi');
Route::get('/download/{id}', [HomeController::class, 'materi_download'])->name('materi_download');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'doRegister'])->name('register.post');

Route::middleware('auth')->group(function () {
    Route::get('/register-school', [AdminSchoolController::class, 'add'])->name('school.register');
    Route::post('/register-school', [AdminSchoolController::class, 'doCreate'])->name('school.register.post');
});

Route::middleware(['auth', 'role:2', 'check.school', 'check.school.status'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('task-categories')->name('task_categories.')->group(function () {
        Route::get('/', [TaskCategoryController::class, 'index'])->name('index');
        Route::get('/add', [TaskCategoryController::class, 'add'])->name('add');
        Route::post('/create', [TaskCategoryController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [TaskCategoryController::class, 'update'])->name('update');
        Route::post('/update/{id}', [TaskCategoryController::class, 'doUpdate'])->name('doUpdate');
        Route::delete('/delete/{id}', [TaskCategoryController::class, 'delete'])->name('delete');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/add', [UserController::class, 'add'])->name('add');
        Route::post('/create', [UserController::class, 'doCreate'])->name('create');
        Route::get('/detail/{id}', [UserController::class, 'detail'])->name('detail');
        Route::get('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::post('/update/{id}', [UserController::class, 'doUpdate'])->name('doUpdate');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::post('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('resetPassword');
    });

    Route::prefix('classrooms')->name('classrooms.')->group(function () {
        Route::get('/', [ClassroomController::class, 'index'])->name('index');
        Route::get('/add', [ClassroomController::class, 'add'])->name('add');
        Route::post('/create', [ClassroomController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [ClassroomController::class, 'update'])->name('update');
        Route::post('/update/{id}', [ClassroomController::class, 'do_update'])->name('do_update');
        Route::get('/detail/{id}', [ClassroomController::class, 'detail'])->name('detail');
        Route::delete('/delete/{id}', [ClassroomController::class, 'delete'])->name('delete');
    });

    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/add', [StudentController::class, 'add'])->name('add');
        Route::post('/create', [StudentController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [StudentController::class, 'update'])->name('update');
        Route::post('/update/{id}', [StudentController::class, 'do_update'])->name('do_update');
        Route::post('/reset-password/{id}', [StudentController::class, 'doResetPassword'])->name('doResetPassword');
        Route::delete('/delete/{id}', [StudentController::class, 'delete'])->name('delete');
    });

    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/add', [TeacherController::class, 'add'])->name('add');
        Route::post('/create', [TeacherController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [TeacherController::class, 'update'])->name('update');
        Route::post('/update/{id}', [TeacherController::class, 'do_update'])->name('do_update');
        Route::post('/reset-password/{id}', [TeacherController::class, 'doResetPassword'])->name('doResetPassword');
        Route::delete('/delete/{id}', [TeacherController::class, 'delete'])->name('delete');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/change-password', [UserController::class, 'changePassword'])->name('change_password');
        Route::post('/change-password', [UserController::class, 'doChangePassword'])->name('do_change_password');
    });

    Route::prefix('text-prompts')->name('text-prompt.')->group(function () {
        Route::get('/', [TextPromptController::class, 'index'])->name('index');
        Route::get('/add', [TextPromptController::class, 'add'])->name('add');
        Route::post('/create', [TextPromptController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [TextPromptController::class, 'edit'])->name('update');
        Route::post('/update/{id}', [TextPromptController::class, 'do_update'])->name('do_update');
        Route::delete('/delete/{id}', [TextPromptController::class, 'delete'])->name('delete');
    });
}); // End Admin Group

Route::middleware(['auth', 'role:3', 'check.school.status'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::prefix('ai-tools')->name('ai.')->group(function () {
        Route::prefix('materi-ajar')->name('materi_ajar.')->group(function () {
            Route::get('/', [MateriAjarController::class, 'index'])->name('index');
            Route::get('/add', [MateriAjarController::class, 'create'])->name('add');
            Route::delete('/delete/{id}', [MateriAjarController::class, 'delete'])->name('delete');
            Route::get('/detail/{id}', [MateriAjarController::class, 'detail'])->name('detail');
        });
        Route::prefix('ilustrasi')->name('ilustrasi.')->group(function () {
            Route::get('/', [IlustrationController::class, 'index'])->name('index');
            Route::get('/add', [IlustrationController::class, 'create'])->name('add');
            Route::get('/status/{referenceId}', [IlustrationController::class, 'JobImageStatus'])->name('job_status');
            Route::post('/create', [IlustrationController::class, 'doCreate'])->name('do_create');
            Route::delete('/delete/{id}', [IlustrationController::class, 'delete'])->name('delete');
            Route::get('/detail/{id}', [IlustrationController::class, 'detail'])->name('detail');
        });
        Route::prefix('quiz-generator')->name('quiz_generator.')->group(function () {
            Route::get('/', [QuizGeneratorController::class, 'index'])->name('index');
            Route::get('/add', [QuizGeneratorController::class, 'create'])->name('add');
            Route::post('/create', [ToolsController::class, 'doCreateQuiz'])->name('do_create');
            Route::delete('/delete/{id}', [QuizGeneratorController::class, 'delete'])->name('delete');
            Route::get('/detail/{id}', [QuizGeneratorController::class, 'detail'])->name('detail');
            Route::get('/scores/{id}', [QuizGeneratorController::class, 'scores'])->name('scores');
        });
    });

    Route::post('api/ilustration/save-history', [ToolsController::class, 'saveHistory'])->name('save_ilustration_history');
    Route::post('api/text-generation/save-history', [ToolsController::class, 'saveTextHistory'])->name('save_text_history');

    Route::prefix('learning-modules')->name('learning_modules.')->group(function () {
        Route::get('/', [LearningModulesController::class, 'index'])->name('index');
        Route::get('/add', [LearningModulesController::class, 'add'])->name('add');
        Route::post('/create', [LearningModulesController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [LearningModulesController::class, 'update'])->name('update');
        Route::post('/update/{id}', [LearningModulesController::class, 'do_update'])->name('do_update');
        Route::get('/detail/{id}', [LearningModulesController::class, 'detail'])->name('detail');
        Route::delete('/delete/{id}', [LearningModulesController::class, 'delete'])->name('delete');
    });

    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/add', [TaskController::class, 'add'])->name('add');
        Route::post('/create', [TaskController::class, 'doCreate'])->name('do_create');
        Route::get('/update/{id}', [TaskController::class, 'update'])->name('update');
        Route::post('/update/{id}', [TaskController::class, 'do_update'])->name('do_update');
        Route::delete('/delete/{id}', [TaskController::class, 'delete'])->name('delete');
    });

    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/', [QuizController::class, 'index'])->name('index');
        Route::get('/add', [QuizController::class, 'create'])->name('add');
        Route::post('/store', [QuizController::class, 'store'])->name('store');
        Route::get('/detail/{id}', [QuizController::class, 'detail'])->name('detail');
        Route::get('/{id}/questions/add', [QuizController::class, 'addQuestions'])->name('questions.add');
        Route::post('/{id}/questions/store', [QuizController::class, 'storeQuestions'])->name('questions.store');
        Route::post('/questions/{id}/update', [QuizController::class, 'updateQuestion'])->name('questions.update');
        Route::delete('/questions/{id}/delete', [QuizController::class, 'deleteQuestion'])->name('questions.delete');
        Route::get('/edit/{id}', [QuizController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [QuizController::class, 'update'])->name('update');
        Route::get('/scores/{id}', [QuizController::class, 'scores'])->name('scores');
        Route::delete('/delete/{id}', [QuizController::class, 'delete'])->name('delete');
    });
});

// Superadmin Group
Route::middleware(['auth', 'role:1'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [SuperAdminUserController::class, 'index'])->name('index');
        Route::get('/add', [SuperAdminUserController::class, 'add'])->name('add');
        Route::post('/create', [SuperAdminUserController::class, 'doCreate'])->name('create');
        Route::get('/detail/{id}', [SuperAdminUserController::class, 'detail'])->name('detail');
        Route::get('/update/{id}', [SuperAdminUserController::class, 'update'])->name('update');
        Route::post('/update/{id}', [SuperAdminUserController::class, 'doUpdate'])->name('doUpdate');
        Route::delete('/delete/{id}', [SuperAdminUserController::class, 'delete'])->name('delete');
        Route::post('/reset-password/{id}', [SuperAdminUserController::class, 'resetPassword'])->name('resetPassword');
    });

    Route::prefix('schools')->name('schools.')->group(function () {
        Route::get('/', [SchoolController::class, 'index'])->name('index');
        Route::get('/add', [SchoolController::class, 'add'])->name('add');
        Route::post('/create', [SchoolController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [SchoolController::class, 'update'])->name('update');
        Route::post('/update/{id}', [SchoolController::class, 'do_update'])->name('do_update');
        Route::delete('/delete/{id}', [SchoolController::class, 'delete'])->name('delete');
        Route::post('/restore/{id}', [SchoolController::class, 'restore'])->name('restore');
    });

    Route::prefix('image-prompts')->name('image-prompts.')->group(function () {
        Route::get('/', [PromptImageController::class, 'index'])->name('index');
        Route::get('/add', [PromptImageController::class, 'add'])->name('add');
        Route::post('/create', [PromptImageController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [PromptImageController::class, 'edit'])->name('update');
        Route::post('/update/{id}', [PromptImageController::class, 'do_update'])->name('do_update');
        Route::delete('/delete/{id}', [PromptImageController::class, 'delete'])->name('delete');
    });

    Route::prefix('subjects')->name('subjects.')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('index');
        Route::get('/add', [SubjectController::class, 'add'])->name('add');
        Route::post('/create', [SubjectController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [SubjectController::class, 'update'])->name('update');
        Route::post('/update/{id}', [SubjectController::class, 'do_update'])->name('do_update');
        Route::delete('/delete/{id}', [SubjectController::class, 'delete'])->name('delete');
    });
});

Route::middleware(['auth', 'role:4', 'check.school.status'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('learning-modules')->name('learning_modules.')->group(function () {
        Route::get('/', [StudentLearningModulesController::class, 'index'])->name('index');
        Route::get('/download/{id}', [studentLearningModulesController::class, 'download'])->middleware(['throttle:1,1'])->name('download');
    });

    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/', [StudentQuizController::class, 'index'])->name('index');
        Route::get('/start', [StudentQuizController::class, 'start'])->name('start');
        Route::get('/quizsoal/{code}', [StudentQuizController::class, 'quizsoal'])->name('quizsoal');
        Route::post('/hasilquiz', [StudentQuizController::class, 'hasilquiz'])->name('hasilquiz');
    });
});
