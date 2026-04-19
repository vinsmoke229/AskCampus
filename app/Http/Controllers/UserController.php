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
        $questions = $user->questions()->with('tags')->withCount('answers')->latest()->paginate(5, ['*'], 'questions_page');
        $answers   = $user->answers()->with(['question.tags'])->latest()->paginate(5, ['*'], 'answers_page');
        
        $stats = [
            'questions_count' => $user->questions()->count(),
            'answers_count'   => $user->answers()->count(),
            'accepted_answers'=> $user->answers()->where('is_accepted', true)->count(),
        ];

        // Calcul des badges honorifiques (basé sur la réputation)
        $rep = $user->reputation ?? 0;
        $badges = [
            'gold'   => floor($rep / 1000),
            'silver' => floor(($rep % 1000) / 100),
            'bronze' => floor(($rep % 100) / 10),
        ];

        // Top tags (tags utilisés dans leurs questions, sans limite pour l'onglet Tags)
        $allTags = \App\Models\Tag::select('tags.*')
                    ->join('question_tag', 'tags.id', '=', 'question_tag.tag_id')
                    ->join('questions', 'question_tag.question_id', '=', 'questions.id')
                    ->where('questions.user_id', $user->id)
                    ->selectRaw('COUNT(questions.id) as user_posts_count')
                    ->groupBy('tags.id', 'tags.name', 'tags.slug', 'tags.created_at', 'tags.updated_at')
                    ->orderByDesc('user_posts_count')
                    ->get();
        
        $topTags = $allTags->take(6); // Pour le composant résumé

        // Historique récent pour la réputation (fusion de questions et réponses récentes)
        $recentQuestions = $user->questions()->latest()->take(10)->get();
        $recentAnswers = $user->answers()->with('question')->latest()->take(10)->get();
        $activities = collect();
        foreach($recentQuestions as $q) {
            $activities->push(['type' => 'question', 'model' => $q, 'date' => $q->created_at, 'score' => $q->vote_score]);
        }
        foreach($recentAnswers as $a) {
            $activities->push(['type' => 'answer', 'model' => $a, 'date' => $a->created_at, 'score' => $a->vote_score]);
        }
        $activities = $activities->sortByDesc('date')->take(15);

        // Impact : Somme des vues pour les questions (people reached)
        $peopleReached = $user->questions()->sum('views');

        // Top Questions
        $topQuestions = $user->questions()
            ->withSum('votes', 'value')
            ->orderByRaw('COALESCE(votes_sum_value, 0) DESC')
            ->take(6)
            ->get();

        // Top Answers
        $topAnswers = $user->answers()->with('question')
            ->withSum('votes', 'value')
            ->orderByRaw('COALESCE(votes_sum_value, 0) DESC')
            ->take(6)
            ->get();

        return view('users.show', compact('user', 'questions', 'answers', 'stats', 'badges', 'topTags', 'allTags', 'activities', 'topQuestions', 'topAnswers', 'peopleReached'));
    }

    /**
     * Affiche la liste des utilisateurs (public)
     */
    public function index(Request $request)
    {
        $query  = $request->input('q', '');
        $sort   = $request->input('sort', 'reputation');
        $filter = $request->input('filter', 'all');

        $users = User::withCount(['questions', 'answers'])->where('name', '!=', 'admin');

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

        $users = $users->paginate(36)->withQueryString();

        // Récupérer les 3 tags les plus utilisés pour chaque utilisateur dans la page courante
        foreach ($users->items() as $u) {
            $u->top_tags = \App\Models\Tag::select('tags.id', 'tags.name', 'tags.slug')
                ->join('question_tag', 'tags.id', '=', 'question_tag.tag_id')
                ->join('questions', 'question_tag.question_id', '=', 'questions.id')
                ->where('questions.user_id', $u->id)
                ->selectRaw('COUNT(questions.id) as posts_count')
                ->groupBy('tags.id', 'tags.name', 'tags.slug')
                ->orderByDesc('posts_count')
                ->take(3)
                ->get();
        }

        return view('users.index', compact('users', 'query', 'sort', 'filter'));
    }
}
