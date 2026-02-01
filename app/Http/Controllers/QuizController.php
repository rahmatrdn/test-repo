<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function quizsoal() {
        return view('_home.quiz.soal');
    }
}
