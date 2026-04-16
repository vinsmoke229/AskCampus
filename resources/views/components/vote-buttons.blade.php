@props(['votable', 'type', 'question' => null])

@php
    $score = $votable->vote_score;
    $userVote = $votable->userVote();
    $isAnswer = $type === 'App\Models\Answer';
@endphp

<div class="flex flex-col items-center space-y-2">
    <!-- Bouton Upvote -->
    @auth
        <form action="{{ route('vote') }}" method="POST">
            @csrf
            <input type="hidden" name="votable_type" value="{{ $type }}">
            <input type="hidden" name="votable_id" value="{{ $votable->id }}">
            <input type="hidden" name="value" value="1">
            <button 
                type="submit" 
                class="p-2 rounded-lg hover:bg-gray-100 transition {{ $userVote === 1 ? 'bg-green-100' : '' }}"
                @if($votable->user_id === auth()->id()) disabled title="Vous ne pouvez pas voter sur votre propre contenu" @endif
            >
                <svg class="w-8 h-8 {{ $userVote === 1 ? 'text-green-600' : 'text-gray-600 hover:text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="p-2 rounded-lg hover:bg-gray-100 transition" title="Connectez-vous pour voter">
            <svg class="w-8 h-8 text-gray-600 hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </a>
    @endauth

    <!-- Score -->
    <div class="text-2xl font-bold {{ $score > 0 ? 'text-green-600' : ($score < 0 ? 'text-red-600' : 'text-gray-700') }}">
        {{ $score }}
    </div>

    <!-- Bouton Downvote -->
    @auth
        <form action="{{ route('vote') }}" method="POST">
            @csrf
            <input type="hidden" name="votable_type" value="{{ $type }}">
            <input type="hidden" name="votable_id" value="{{ $votable->id }}">
            <input type="hidden" name="value" value="-1">
            <button 
                type="submit" 
                class="p-2 rounded-lg hover:bg-gray-100 transition {{ $userVote === -1 ? 'bg-red-100' : '' }}"
                @if($votable->user_id === auth()->id()) disabled title="Vous ne pouvez pas voter sur votre propre contenu" @endif
            >
                <svg class="w-8 h-8 {{ $userVote === -1 ? 'text-red-600' : 'text-gray-600 hover:text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="p-2 rounded-lg hover:bg-gray-100 transition" title="Connectez-vous pour voter">
            <svg class="w-8 h-8 text-gray-600 hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </a>
    @endauth

    <!-- Bouton Accepter (uniquement pour les réponses) -->
    @if($isAnswer && $question && auth()->check())
        @if($question->user_id === auth()->id() && !$votable->is_accepted)
            <form action="{{ route('answers.accept', $votable) }}" method="POST" class="mt-2">
                @csrf
                @method('PATCH')
                <button type="submit" class="p-2 rounded-lg hover:bg-green-100 transition" title="Accepter cette réponse">
                    <svg class="w-8 h-8 text-gray-400 hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </form>
        @endif

        @if($votable->is_accepted)
            <div class="mt-2 p-2 bg-green-500 rounded-lg">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
        @endif
    @endif
</div>
