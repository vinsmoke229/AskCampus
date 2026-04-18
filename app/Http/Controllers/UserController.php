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
    public function index(Request $request)
    {
        $query  = $request->input('q', '');
        $sort   = $request->input('sort', 'reputation');
        $filter = $request->input('filter', 'all');

        $users = User::withCount(['questions', 'answers']);

        // Recherche par nom
        if ($query !== '') {
            $users->where('name', 'like', "%{$query}%");
        }

        // Filtres
        if ($filter === 'moderators') {
            $users->where('is_moderator', true);
        } elseif ($filter === 'new') {
            $users->where('created_at', '>=', now()->subDays(7));
        }

        // Tri
        match ($sort) {
            'name'       => $users->orderBy('name'),
            'newest'     => $users->latest(),
            default      => $users->orderByDesc('reputation'),
        };

        $users = $users->paginate(30)->withQueryString();

        return view('users.index', compact('users', 'query', 'sort', 'filter'));
    }
}
