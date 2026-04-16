<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

// Page d'accueil redirige vers les questions
Route::get('/', function () {
    return redirect()->route('questions.index');
});

// Dashboard (nécessite authentification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes publiques (lecture seule)
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

// Routes protégées (nécessitent authentification)
Route::middleware('auth')->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Questions (création uniquement)
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    
    // API pour recherche de questions similaires (anti-doublon)
    Route::get('/api/questions/similar', [QuestionController::class, 'searchSimilar'])->name('questions.similar');

    // Réponses
    Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');
    Route::patch('/answers/{answer}/accept', [AnswerController::class, 'accept'])->name('answers.accept');

    // Votes
    Route::post('/vote', [VoteController::class, 'vote'])->name('vote');
});

// Routes modérateur
Route::middleware(['auth', 'moderator'])->group(function () {
    // Modération des questions
    Route::patch('/questions/{question}/close', [QuestionController::class, 'close'])->name('questions.close');
    Route::patch('/questions/{question}/reopen', [QuestionController::class, 'reopen'])->name('questions.reopen');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    
    // Modération des réponses
    Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');
});

require __DIR__.'/auth.php';
