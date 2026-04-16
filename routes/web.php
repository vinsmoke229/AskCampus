<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

// Page d'accueil : dashboard si connecté, sinon questions
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('questions.index');
});

// Dashboard (nécessite authentification)
Route::get('/dashboard', function () {
    // Si l'utilisateur est modérateur, afficher le dashboard de modération
    if (auth()->user()->isModerator()) {
        $data = [
            'modStats' => [
                'totalQuestions' => \App\Models\Question::count(),
                'openQuestions'  => \App\Models\Question::where('is_solved', false)->where('is_closed', false)->count(),
                'closedQuestions'=> \App\Models\Question::where('is_closed', true)->count(),
                'totalAnswers'   => \App\Models\Answer::count(),
                'totalUsers'     => \App\Models\User::count(),
                'totalTags'      => \App\Models\Tag::count(),
            ],
            'recentQuestions' => \App\Models\Question::with(['user', 'tags', 'answers'])->latest()->take(15)->get(),
            'recentAnswers'   => \App\Models\Answer::with(['user', 'question'])->latest()->take(10)->get(),
            'recentUsers'     => \App\Models\User::latest()->take(8)->get(),
        ];
        return view('dashboard', $data);
    }
    
    // Sinon, afficher la page d'accueil personnalisée
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');


// Routes publiques (lecture seule)
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

// Tags (page publique)
Route::get('/tags', [App\Http\Controllers\TagController::class, 'index'])->name('tags.index');

// Profils publics et liste des utilisateurs
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');

// Routes protégées (nécessitent authentification)
Route::middleware('auth')->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Page de profil publique (vue Stack Overflow)
    Route::get('/mon-profil', function () {
        return view('profile.show');
    })->name('profile.show');

    // Questions (création uniquement) - DOIT être AVANT questions.show
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

// Route publique pour voir une question - DOIT être APRÈS /questions/create
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

// Routes modérateur
Route::middleware(['auth', 'moderator'])->group(function () {
    // Modération des questions
    Route::patch('/questions/{question}/close', [QuestionController::class, 'close'])->name('questions.close');
    Route::patch('/questions/{question}/reopen', [QuestionController::class, 'reopen'])->name('questions.reopen');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    
    // Modération des réponses
    Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');

    // Gestion des tags (modérateur uniquement - création, édition, suppression)
    Route::resource('tags', App\Http\Controllers\TagController::class)->except(['create', 'show', 'index']);
});

require __DIR__.'/auth.php';
