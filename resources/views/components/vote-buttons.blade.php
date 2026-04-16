@props(['votable', 'type', 'question' => null])

@php
    $score    = $votable->vote_score;
    $userVote = $votable->userVote();
    $isAnswer = $type === 'App\Models\Answer';
    $ownerId  = $votable->user_id ?? null;
    $isOwner  = auth()->check() && auth()->id() === $ownerId;
@endphp

<div style="display:flex;flex-direction:column;align-items:center;gap:4px;width:48px;flex-shrink:0;">

    {{-- ── Up Vote ── --}}
    @auth
        <form action="{{ route('vote') }}" method="POST">
            @csrf
            <input type="hidden" name="votable_type" value="{{ $type }}">
            <input type="hidden" name="votable_id"   value="{{ $votable->id }}">
            <input type="hidden" name="value"         value="1">
            <button type="submit"
                    title="{{ $isOwner ? 'Vous ne pouvez pas voter sur votre contenu' : 'Vote positif' }}"
                    {{ $isOwner ? 'disabled' : '' }}
                    style="width:36px;height:36px;border-radius:50%;border:2px solid {{ $userVote === 1 ? '#5046e5' : '#e5e7eb' }};
                           background:{{ $userVote === 1 ? '#5046e5' : '#fff' }};
                           color:{{ $userVote === 1 ? '#fff' : '#9ca3af' }};
                           display:flex;align-items:center;justify-content:center;
                           cursor:{{ $isOwner ? 'not-allowed' : 'pointer' }};
                           padding:0;transition:all .15s;opacity:{{ $isOwner ? '.4' : '1' }};"
                    onmouseover="if(!this.disabled){ this.style.borderColor='#5046e5'; this.style.color='#5046e5'; this.style.background='#eef2ff'; }"
                    onmouseout="if(!this.disabled && {{ $userVote === 1 ? 'false' : 'true' }}){ this.style.borderColor='#e5e7eb'; this.style.color='#9ca3af'; this.style.background='#fff'; }">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                </svg>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" title="Connectez-vous pour voter"
           style="width:36px;height:36px;border-radius:50%;border:2px solid #e5e7eb;
                  background:#fff;color:#d1d5db;
                  display:flex;align-items:center;justify-content:center;"
           onmouseover="this.style.borderColor='#5046e5';this.style.color='#5046e5';this.style.background='#eef2ff';"
           onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#d1d5db';this.style.background='#fff';">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
            </svg>
        </a>
    @endauth

    {{-- ── Score ── --}}
    <div style="font-size:20px;font-weight:800;line-height:1;padding:2px 0;
                color:{{ $score > 0 ? '#5046e5' : ($score < 0 ? '#dc2626' : '#6b7280') }};">
        {{ $score }}
    </div>

    {{-- ── Down Vote ── --}}
    @auth
        <form action="{{ route('vote') }}" method="POST">
            @csrf
            <input type="hidden" name="votable_type" value="{{ $type }}">
            <input type="hidden" name="votable_id"   value="{{ $votable->id }}">
            <input type="hidden" name="value"         value="-1">
            <button type="submit"
                    title="{{ $isOwner ? 'Vous ne pouvez pas voter sur votre contenu' : 'Vote négatif' }}"
                    {{ $isOwner ? 'disabled' : '' }}
                    style="width:36px;height:36px;border-radius:50%;border:2px solid {{ $userVote === -1 ? '#dc2626' : '#e5e7eb' }};
                           background:{{ $userVote === -1 ? '#dc2626' : '#fff' }};
                           color:{{ $userVote === -1 ? '#fff' : '#9ca3af' }};
                           display:flex;align-items:center;justify-content:center;
                           cursor:{{ $isOwner ? 'not-allowed' : 'pointer' }};
                           padding:0;transition:all .15s;opacity:{{ $isOwner ? '.4' : '1' }};"
                    onmouseover="if(!this.disabled){ this.style.borderColor='#dc2626'; this.style.color='#dc2626'; this.style.background='#fef2f2'; }"
                    onmouseout="if(!this.disabled && {{ $userVote === -1 ? 'false' : 'true' }}){ this.style.borderColor='#e5e7eb'; this.style.color='#9ca3af'; this.style.background='#fff'; }">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" title="Connectez-vous pour voter"
           style="width:36px;height:36px;border-radius:50%;border:2px solid #e5e7eb;
                  background:#fff;color:#d1d5db;
                  display:flex;align-items:center;justify-content:center;"
           onmouseover="this.style.borderColor='#dc2626';this.style.color='#dc2626';this.style.background='#fef2f2';"
           onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#d1d5db';this.style.background='#fff';">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
        </a>
    @endauth

    {{-- ── Accept button (answer owner = question author) ── --}}
    @if($isAnswer && $question && auth()->check())
        @if($question->user_id === auth()->id() && !$votable->is_accepted && !$question->is_closed)
            <form action="{{ route('answers.accept', $votable) }}" method="POST" style="margin-top:6px;">
                @csrf @method('PATCH')
                <button type="submit" title="Marquer comme meilleure réponse"
                        style="width:36px;height:36px;border-radius:50%;
                               border:2px dashed #d1d5db;background:#fff;color:#9ca3af;
                               display:flex;align-items:center;justify-content:center;
                               cursor:pointer;padding:0;transition:all .15s;"
                        onmouseover="this.style.borderColor='#10b981';this.style.color='#10b981';this.style.background='#f0fdf4';"
                        onmouseout="this.style.borderColor='#d1d5db';this.style.color='#9ca3af';this.style.background='#fff';">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
        @endif

        @if($votable->is_accepted)
            <div style="margin-top:6px;width:36px;height:36px;border-radius:50%;
                        background:#10b981;border:2px solid #10b981;
                        display:flex;align-items:center;justify-content:center;"
                 title="Réponse acceptée">
                <svg style="width:16px;height:16px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        @endif
    @endif

</div>
