<?php

use App\Http\Controllers\GenerateTextController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//AI Tools
Route::prefix('tools')->group(function () {
    Route::post('/generate-text', [GenerateTextController::class, 'generate'])->name('generate_text');
    Route::get('/status/{referenceId}', [GenerateTextController::class, 'status'])->name('generate_text_status');
});
