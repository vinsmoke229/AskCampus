<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'votable_id',
        'votable_type',
        'value',
    ];

    protected $casts = [
        'value' => 'integer',
    ];

    /**
     * Get the user that owns the vote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent votable model (Question or Answer).
     */
    public function votable(): MorphTo
    {
        return $this->morphTo();
    }
}
