<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;
use App\Observers\AnswerObserver;
use App\Observers\VoteObserver;
use App\Policies\VotePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enregistrer les Observers
        Vote::observe(VoteObserver::class);
        Answer::observe(AnswerObserver::class);
        
        // Enregistrer les Gates pour les votes
        Gate::define('voteOnQuestion', [VotePolicy::class, 'voteOnQuestion']);
        Gate::define('voteOnAnswer', [VotePolicy::class, 'voteOnAnswer']);
    }
}
