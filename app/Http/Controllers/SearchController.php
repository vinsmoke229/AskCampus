<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Recherche globale : questions + utilisateurs + tags
     */
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $tab   = $request->input('tab', 'questions');

        $questions = collect();
        $users     = collect();
        $tags      = collect();

        if ($query !== '') {
            $questions = Question::with(['user', 'tags', 'answers'])
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('body', 'like', "%{$query}%");
                })
                ->latest()
                ->paginate(15, ['*'], 'qpage')
                ->withQueryString();

            $users = User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orderByDesc('reputation')
                ->paginate(15, ['*'], 'upage')
                ->withQueryString();

            $tags = Tag::withCount('questions')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orderByDesc('questions_count')
                ->paginate(15, ['*'], 'tpage')
                ->withQueryString();
        }

        return view('search.index', compact('query', 'tab', 'questions', 'users', 'tags'));
    }

    /**
     * Recherche dans les questions uniquement
     */
    public function questions(Request $request)
    {
        $query = $request->input('q', '');

        $questions = Question::with(['user', 'tags', 'answers'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('body', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('search.index', [
            'query'     => $query,
            'tab'       => 'questions',
            'questions' => $questions,
            'users'     => collect(),
            'tags'      => collect(),
        ]);
    }

    /**
     * Recherche d'utilisateurs par nom
     */
    public function users(Request $request)
    {
        $query = $request->input('q', '');

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orderByDesc('reputation')
            ->paginate(15)
            ->withQueryString();

        return view('search.index', [
            'query'     => $query,
            'tab'       => 'users',
            'questions' => collect(),
            'users'     => $users,
            'tags'      => collect(),
        ]);
    }

    /**
     * Recherche de tags par nom
     */
    public function tags(Request $request)
    {
        $query = $request->input('q', '');

        $tags = Tag::withCount('questions')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orderByDesc('questions_count')
            ->paginate(15)
            ->withQueryString();

        return view('search.index', [
            'query'     => $query,
            'tab'       => 'tags',
            'questions' => collect(),
            'users'     => collect(),
            'tags'      => $tags,
        ]);
    }
}
