<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Affiche la liste des questions avec recherche et filtres
     */
    public function index(Request $request)
    {
        // Requête de base avec relations
        $query = Question::with(['user', 'tags', 'answers', 'votes']);

        // Recherche par mots-clés (titre ou contenu)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // Filtre par tag (slug)
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->input('tag'));
            });
        }

        // Filtre par statut (résolu/non résolu)
        if ($request->filled('filter')) {
            if ($request->input('filter') === 'solved') {
                $query->where('is_solved', true);
            } elseif ($request->input('filter') === 'unsolved') {
                $query->where('is_solved', false);
            }
        }

        // Tri
        if ($request->input('sort') === 'active') {
            // Questions avec l'activité la plus récente (dernière réponse)
            $query->leftJoin('answers as a_sort', 'questions.id', '=', 'a_sort.question_id')
                  ->select('questions.*')
                  ->groupBy('questions.id')
                  ->orderByRaw('COALESCE(MAX(a_sort.created_at), questions.created_at) DESC');
        } else {
            $query->latest();
        }

        $questions = $query->paginate(15);

        return view('questions.index', compact('questions'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $tags = Tag::all();
        return view('questions.create', compact('tags'));
    }

    /**
     * Enregistre une nouvelle question
     */
    public function store(StoreQuestionRequest $request)
    {
        // Créer la question pour l'utilisateur connecté
        $question = auth()->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        // Attacher les tags sélectionnés
        if ($request->filled('tags')) {
            $question->tags()->attach($request->tags);
        }

        return redirect()->route('questions.show', $question)
            ->with('success', 'Question créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Question $question)
    {
        // Vérifier que l'utilisateur est le propriétaire
        if (auth()->id() !== $question->user_id && !auth()->user()->isModerator()) {
            abort(403, 'Vous ne pouvez pas éditer cette question.');
        }

        $tags = Tag::all();
        return view('questions.edit', compact('question', 'tags'));
    }

    /**
     * Met à jour une question
     */
    public function update(StoreQuestionRequest $request, Question $question)
    {
        // Vérifier que l'utilisateur est le propriétaire
        if (auth()->id() !== $question->user_id && !auth()->user()->isModerator()) {
            abort(403, 'Vous ne pouvez pas éditer cette question.');
        }

        $question->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        // Synchroniser les tags
        if ($request->filled('tags')) {
            $question->tags()->sync($request->tags);
        } else {
            $question->tags()->detach();
        }

        return redirect()->route('questions.show', $question)
            ->with('success', 'Question mise à jour avec succès.');
    }

    /**
     * Affiche une question avec ses réponses
     */
    public function show(Question $question)
    {
        // Incrémenter le compteur de vues (sauf si c'est l'auteur)
        if (!auth()->check() || auth()->id() !== $question->user_id) {
            $question->increment('views');
        }

        // Charger les relations nécessaires
        $question->load([
            'user',
            'tags',
            'votes',
            // Réponses triées : acceptées d'abord, puis par score de votes
            'answers' => function ($query) {
                $query->with(['user', 'votes'])
                    ->withCount([
                        'votes as vote_score' => function ($q) {
                            $q->selectRaw('COALESCE(SUM(value), 0)');
                        }
                    ])
                    ->orderByDesc('is_accepted')
                    ->orderByDesc('vote_score');
            }
        ]);

        return view('questions.show', compact('question'));
    }

    /**
     * Recherche de questions similaires (API pour anti-doublon)
     */
    public function searchSimilar(Request $request)
    {
        $title = $request->input('title', '');
        
        if (strlen($title) < 10) {
            return response()->json([]);
        }

        // Rechercher des questions similaires par titre
        $similarQuestions = Question::where('title', 'like', "%{$title}%")
            ->with('tags')
            ->limit(5)
            ->get(['id', 'title', 'is_solved'])
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'title' => $question->title,
                    'is_solved' => $question->is_solved,
                    'url' => route('questions.show', $question),
                ];
            });

        return response()->json($similarQuestions);
    }

    /**
     * Ferme une question (modérateur uniquement)
     */
    public function close(Question $question)
    {
        $question->update(['is_closed' => true]);

        return redirect()->route('questions.show', $question)
            ->with('success', 'Question fermée avec succès.');
    }

    /**
     * Rouvre une question (modérateur uniquement)
     */
    public function reopen(Question $question)
    {
        $question->update(['is_closed' => false]);

        return redirect()->route('questions.show', $question)
            ->with('success', 'Question rouverte avec succès.');
    }

    /**
     * Supprime une question (modérateur uniquement)
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')
            ->with('success', 'Question supprimée avec succès.');
    }

    /**
     * Suivre/Ne plus suivre une question
     */
    public function toggleFollow(Question $question)
    {
        $user = auth()->user();

        if ($user->followedQuestions()->where('question_id', $question->id)->exists()) {
            // Ne plus suivre
            $user->followedQuestions()->detach($question->id);
            return back()->with('success', 'Vous ne suivez plus cette question.');
        } else {
            // Suivre
            $user->followedQuestions()->attach($question->id);
            return back()->with('success', 'Vous suivez maintenant cette question.');
        }
    }
}
