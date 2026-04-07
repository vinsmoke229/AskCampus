<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Vote;
use App\Observers\AnswerObserver;
use App\Observers\VoteObserver;
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
    }
}
