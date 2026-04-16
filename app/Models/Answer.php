<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'body',
        'is_accepted',
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
    ];

    /**
     * Relation : Question parente
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relation : Utilisateur propriétaire
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Votes polymorphes
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    /**
     * Calcule le score total des votes (somme des +1 et -1)
     */
    public function getVoteScoreAttribute(): int
    {
        return $this->votes->sum('value');
    }

    /**
     * Vérifie si l'utilisateur connecté a voté sur cette réponse
     */
    public function userVote(): ?int
    {
        if (!auth()->check()) {
            return null;
        }

        $vote = $this->votes()->where('user_id', auth()->id())->first();
        return $vote ? $vote->value : null;
    }
}
