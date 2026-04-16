<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'is_solved',
        'views',
        'is_closed',
    ];

    protected $casts = [
        'is_solved' => 'boolean',
        'is_closed' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * Relation : Utilisateur propriétaire
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Réponses de la question
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Relation : Tags de la question
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
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
     * Vérifie si l'utilisateur connecté a voté sur cette question
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
