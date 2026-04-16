<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Affiche le profil public d'un utilisateur
     */
    public function show(User $user)
    {
        // Charger les statistiques de l'utilisateur
        $questions = $user->questions()->latest()->paginate(5, ['*'], 'questions_page');
        $answers   = $user->answers()->with('question')->latest()->paginate(5, ['*'], 'answers_page');
        
        $stats = [
            'questions_count' => $user->questions()->count(),
            'answers_count'   => $user->answers()->count(),
            'accepted_answers'=> $user->answers()->where('is_accepted', true)->count(),
        ];

        return view('users.show', compact('user', 'questions', 'answers', 'stats'));
    }

    /**
     * Affiche la liste des utilisateurs (public)
     */
    public function index()
    {
        $users = User::orderByDesc('reputation')->paginate(30);
        return view('users.index', compact('users'));
    }
}
