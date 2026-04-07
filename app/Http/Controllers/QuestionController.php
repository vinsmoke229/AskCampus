<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions with search and tag filter.
     */
    public function index(Request $request)
    {
        $query = Question::with(['user', 'tags', 'answers']);

        // Recherche par titre ou body
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // Filtre par tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->input('tag'));
            });
        }

        $questions = $query->latest()->paginate(15);

        return view('questions.index', compact('questions'));
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = auth()->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        // Attacher les tags
        if ($request->has('tags')) {
            $question->tags()->attach($request->tags);
        }

        return redirect()->route('questions.show', $question)
            ->with('success', 'Question créée avec succès.');
    }

    /**
     * Display the specified question.
     */
    public function show(Question $question)
    {
        // Incrémenter le compteur de vues
        $question->increment('views');

        // Charger les réponses triées : acceptées d'abord, puis par score de votes
        $question->load(['user', 'tags', 'answers' => function ($query) {
            $query->with(['user', 'votes'])
                ->withCount([
                    'votes as vote_score' => function ($q) {
                        $q->selectRaw('SUM(value)');
                    }
                ])
                ->orderByDesc('is_accepted')
                ->orderByDesc('vote_score');
        }]);

        return view('questions.show', compact('question'));
    }
}
