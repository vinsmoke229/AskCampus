<x-app-layout>

{{-- ══════════════════════════════════════════
     QUESTION DETAIL PAGE - Stack Overflow Style
══════════════════════════════════════════ --}}

<style>
    /* Reset & Base */
    .show-container { max-width: 1264px; margin: 0 auto; }
    .show-grid { display: grid; grid-template-columns: 1fr 300px; gap: 24px; }
    
    /* Header */
    .q-header { margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #e3e6e8; }
    .q-title { font-size: 27px; font-weight: 400; color: #3b4045; line-height: 1.35; margin: 0 0 8px; }
    .q-meta { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6a737c; flex-wrap: wrap; }
    .q-meta-item { display: flex; align-items: center; gap: 4px; }
    .q-meta-sep { color: #d6d9dc; }
    
    /* Post Layout (Question & Answer) */
    .post { display: flex; gap: 16px; padding: 16px 0; border-bottom: 1px solid #e3e6e8; }
    .post:last-child { border-bottom: none; }
    
    /* Vote Column - Nu et aligné en haut */
    .vote-cell { 
        width: 48px; flex-shrink: 0; 
        display: flex; flex-direction: column; align-items: center; gap: 8px;
        padding-top: 4px; /* Alignement avec le texte */
    }
    .vote-btn { 
        width: 36px; height: 36px; border: none; background: transparent;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        color: #babfc4; transition: all 0.1s; border-radius: 50%;
        padding: 0;
    }
    .vote-btn:hover { background: #f8f9f9; color: #6a737c; }
    .vote-btn.voted { background: #f48225; color: #fff; }
    .vote-score { font-size: 21px; font-weight: 400; color: #6a737c; line-height: 1; }
    .vote-check { 
        width: 36px; height: 36px; border: none; background: transparent;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        color: #5eba7d; transition: all 0.1s; border-radius: 50%;
        padding: 0;
    }
    .vote-check:hover { background: #f0fdf4; }
    .vote-check.accepted { background: #5eba7d; color: #fff; }
    
    /* Content Column */
    .post-content { flex: 1; min-width: 0; }
    .post-body { font-size: 15px; color: #232629; line-height: 1.7; margin-bottom: 16px; white-space: pre-line; }
    .post-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 16px; }
    .tag { 
        display: inline-block; padding: 4px 6px; font-size: 12px;
        background: #e1ecf4; color: #39739d; border-radius: 3px;
        text-decoration: none; transition: background 0.1s;
    }
    .tag:hover { background: #d0e3f1; }
    
    /* Post Footer */
    .post-footer { display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 12px; }
    .post-actions { display: flex; gap: 8px; align-items: center; }
    .post-action-btn { 
        font-size: 13px; color: #6a737c; background: transparent; border: none;
        cursor: pointer; padding: 4px 8px; border-radius: 3px;
    }
    .post-action-btn:hover { background: #f8f9f9; }
    
    /* User Card */
    .user-card { 
        padding: 6px 8px; border-radius: 3px; min-width: 200px;
        background: #fff; border: 1px solid #d6d9dc;
    }
    .user-card.owner { background: #e1ecf4; border-color: #c8dae9; }
    .user-card-time { font-size: 12px; color: #6a737c; margin-bottom: 4px; }
    .user-card-info { display: flex; align-items: center; gap: 8px; }
    .user-avatar { 
        width: 32px; height: 32px; border-radius: 3px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px; color: #fff; flex-shrink: 0;
    }
    .user-details { flex: 1; min-width: 0; }
    .user-name { font-size: 13px; color: #0074cc; font-weight: 400; }
    .user-name:hover { color: #0a95ff; }
    .user-rep { font-size: 12px; color: #6a737c; font-weight: 700; }
    
    /* Answers Section */
    .answers-header { 
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 0; margin: 24px 0 16px; border-top: 1px solid #e3e6e8;
    }
    .answers-title { font-size: 19px; font-weight: 400; color: #232629; }
    .answers-sort { font-size: 13px; color: #6a737c; }
    
    /* Answer Form */
    .answer-form { margin-top: 24px; padding-top: 24px; border-top: 1px solid #e3e6e8; }
    .answer-form-title { font-size: 19px; font-weight: 400; color: #232629; margin-bottom: 16px; }
    .answer-textarea { 
        width: 100%; min-height: 200px; padding: 10px; font-size: 13px;
        border: 1px solid #babfc4; border-radius: 3px; font-family: inherit;
        color: #232629; resize: vertical; outline: none;
    }
    .answer-textarea:focus { border-color: #6cbbf7; box-shadow: 0 0 0 4px rgba(0,149,255,0.15); }
    .answer-submit { 
        margin-top: 12px; padding: 10px 12px; font-size: 13px; font-weight: 400;
        background: #0a95ff; color: #fff; border: 1px solid transparent;
        border-radius: 3px; cursor: pointer; transition: background 0.1s;
    }
    .answer-submit:hover { background: #0074cc; }
    
    /* Sidebar */
    .sidebar-widget { 
        background: #fdf7e2; border: 1px solid #f1e5bc; border-radius: 3px;
        padding: 12px; margin-bottom: 16px;
    }
    .sidebar-widget-title { font-size: 12px; font-weight: 700; color: #3b4045; margin-bottom: 8px; }
    .sidebar-widget-body { font-size: 13px; color: #3b4045; line-height: 1.5; }
    .sidebar-stats { background: #fff; border: 1px solid #d6d9dc; border-radius: 3px; padding: 12px; }
    .sidebar-stat { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
    .sidebar-stat-label { color: #6a737c; }
    .sidebar-stat-value { color: #232629; font-weight: 700; }
    
    /* Badges */
    .badge { 
        display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px;
        font-size: 11px; font-weight: 700; border-radius: 3px;
    }
    .badge-solved { background: #d4edda; color: #155724; }
    .badge-closed { background: #f8d7da; color: #721c24; }
    .badge-accepted { background: #d4edda; color: #155724; margin-bottom: 8px; }
    
    /* Mod Actions */
    .mod-actions { display: flex; gap: 6px; flex-wrap: wrap; }
    .mod-btn { 
        padding: 6px 10px; font-size: 12px; font-weight: 400;
        border: 1px solid #d6d9dc; border-radius: 3px; background: #fff;
        color: #6a737c; cursor: pointer; transition: all 0.1s;
    }
    .mod-btn:hover { background: #f8f9f9; }
    .mod-btn-danger { color: #d93025; border-color: #d93025; }
    .mod-btn-danger:hover { background: #fef2f2; }
    .mod-btn-warn { color: #f48225; border-color: #f48225; }
    .mod-btn-warn:hover { background: #fff8f0; }
    .mod-btn-success { color: #5eba7d; border-color: #5eba7d; }
    .mod-btn-success:hover { background: #f0fdf4; }
</style>

<div class="show-container">
    
    {{-- ══════════ HEADER ══════════ --}}
    <div class="q-header">
        <h1 class="q-title">{{ $question->title }}</h1>
        <div class="q-meta">
            <div class="q-meta-item">
                <span>Posée</span>
                <strong>{{ $question->created_at->diffForHumans() }}</strong>
            </div>
            <span class="q-meta-sep">•</span>
            <div class="q-meta-item">
                <span>Vue</span>
                <strong>{{ number_format($question->views) }} fois</strong>
            </div>
            <span class="q-meta-sep">•</span>
            <div class="q-meta-item">
                @if($question->is_solved)
                    <span class="badge badge-solved">✓ Résolue</span>
                @elseif($question->is_closed)
                    <span class="badge badge-closed">🔒 Fermée</span>
                @else
                    <span style="color:#5eba7d;font-weight:700;">Active</span>
                @endif
            </div>
        </div>
    </div>
    
    <div class="show-grid">
        
        {{-- ══════════ MAIN CONTENT ══════════ --}}
        <div>
            
            {{-- ── Question Post ── --}}
            <div class="post">
                
                {{-- Vote Column --}}
                <div class="vote-cell">
                    @auth
                        <form method="POST" action="{{ route('vote') }}">
                            @csrf
                            <input type="hidden" name="votable_id" value="{{ $question->id }}">
                            <input type="hidden" name="votable_type" value="App\Models\Question">
                            <input type="hidden" name="value" value="1">
                            <button type="submit" class="vote-btn {{ $question->userVote() === 1 ? 'voted' : '' }}">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                    <path d="M1 12h16L9 4z"/>
                                </svg>
                            </button>
                        </form>
                    @else
                        <button class="vote-btn" onclick="window.location='{{ route('login') }}'">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                <path d="M1 12h16L9 4z"/>
                            </svg>
                        </button>
                    @endauth
                    
                    <div class="vote-score">{{ $question->vote_score }}</div>
                    
                    @auth
                        <form method="POST" action="{{ route('vote') }}">
                            @csrf
                            <input type="hidden" name="votable_id" value="{{ $question->id }}">
                            <input type="hidden" name="votable_type" value="App\Models\Question">
                            <input type="hidden" name="value" value="-1">
                            <button type="submit" class="vote-btn {{ $question->userVote() === -1 ? 'voted' : '' }}">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                    <path d="M1 6h16l-8 8z"/>
                                </svg>
                            </button>
                        </form>
                    @else
                        <button class="vote-btn" onclick="window.location='{{ route('login') }}'">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                <path d="M1 6h16l-8 8z"/>
                            </svg>
                        </button>
                    @endauth
                </div>
                
                {{-- Content Column --}}
                <div class="post-content">
                    <div class="post-body">{{ $question->body }}</div>
                    
                    {{-- Tags --}}
                    @if($question->tags->count() > 0)
                        <div class="post-tags">
                            @foreach($question->tags as $tag)
                                <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="tag">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                    
                    {{-- Footer --}}
                    <div class="post-footer">
                        <div class="post-actions">
                            <button class="post-action-btn">Partager</button>
                            <button class="post-action-btn">Suivre</button>
                            
                            @auth
                                {{-- Boutons Edit et Delete pour le propriétaire --}}
                                @if(auth()->id() === $question->user_id)
                                    <a href="{{ route('questions.edit', $question) }}" class="post-action-btn" style="color:#0074cc;">
                                        Éditer
                                    </a>
                                    <form method="POST" action="{{ route('questions.destroy', $question) }}" style="display:inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="post-action-btn" style="color:#d93025;">
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                                
                                {{-- Boutons modérateur --}}
                                @if(auth()->user()->isModerator())
                                    <div class="mod-actions">
                                        @if($question->is_closed)
                                            <form method="POST" action="{{ route('questions.reopen', $question) }}" style="display:inline;">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="mod-btn mod-btn-success">Rouvrir</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('questions.close', $question) }}" style="display:inline;">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="mod-btn mod-btn-warn">Fermer</button>
                                            </form>
                                        @endif
                                        @if(auth()->id() !== $question->user_id)
                                            <form method="POST" action="{{ route('questions.destroy', $question) }}" style="display:inline;"
                                                  onsubmit="return confirm('Supprimer cette question ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="mod-btn mod-btn-danger">Supprimer</button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>
                        
                        {{-- User Card --}}
                        @php
                            $colors = ['#0074cc','#5eba7d','#f48225','#d93025','#8b5cf6','#0891b2'];
                            $colorIndex = abs(crc32($question->user->name ?? '')) % count($colors);
                        @endphp
                        <div class="user-card owner">
                            <div class="user-card-time">posée {{ $question->created_at->diffForHumans() }}</div>
                            <div class="user-card-info">
                                <div class="user-avatar" style="background:{{ $colors[$colorIndex] }};">
                                    {{ strtoupper(substr($question->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <a href="#" class="user-name">{{ $question->user->name }}</a>
                                    <div class="user-rep">{{ number_format($question->user->reputation ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- ══════════ ANSWERS SECTION ══════════ --}}
            @if($question->answers->count() > 0)
                <div class="answers-header">
                    <h2 class="answers-title">
                        {{ $question->answers->count() }} 
                        {{ $question->answers->count() > 1 ? 'Réponses' : 'Réponse' }}
                    </h2>
                    <div class="answers-sort">
                        <span style="color:#232629;">Triées par:</span> Plus de votes
                    </div>
                </div>
                
                @php
                    $sortedAnswers = $question->answers
                        ->sortByDesc('is_accepted')
                        ->sortByDesc(fn($a) => $a->votes->sum('value'));
                @endphp
                
                @foreach($sortedAnswers as $answer)
                    @php
                        $answerColorIndex = abs(crc32($answer->user->name ?? '')) % count($colors);
                        $voteScore = $answer->votes->sum('value');
                        $userVote = auth()->check() 
                            ? optional($answer->votes()->where('user_id', auth()->id())->first())->value 
                            : null;
                    @endphp
                    
                    <div class="post">
                        
                        {{-- Vote Column --}}
                        <div class="vote-cell">
                            @auth
                                <form method="POST" action="{{ route('vote') }}">
                                    @csrf
                                    <input type="hidden" name="votable_id" value="{{ $answer->id }}">
                                    <input type="hidden" name="votable_type" value="App\Models\Answer">
                                    <input type="hidden" name="value" value="1">
                                    <button type="submit" class="vote-btn {{ $userVote === 1 ? 'voted' : '' }}">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                            <path d="M1 12h16L9 4z"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <button class="vote-btn" onclick="window.location='{{ route('login') }}'">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                        <path d="M1 12h16L9 4z"/>
                                    </svg>
                                </button>
                            @endauth
                            
                            <div class="vote-score">{{ $voteScore }}</div>
                            
                            @auth
                                <form method="POST" action="{{ route('vote') }}">
                                    @csrf
                                    <input type="hidden" name="votable_id" value="{{ $answer->id }}">
                                    <input type="hidden" name="votable_type" value="App\Models\Answer">
                                    <input type="hidden" name="value" value="-1">
                                    <button type="submit" class="vote-btn {{ $userVote === -1 ? 'voted' : '' }}">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                            <path d="M1 6h16l-8 8z"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <button class="vote-btn" onclick="window.location='{{ route('login') }}'">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                        <path d="M1 6h16l-8 8z"/>
                                    </svg>
                                </button>
                            @endauth
                            
                            {{-- Accept Button (Question Owner Only) --}}
                            @auth
                                @if(auth()->id() === $question->user_id && !$question->is_closed)
                                    <form method="POST" action="{{ route('answers.accept', $answer) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="vote-check {{ $answer->is_accepted ? 'accepted' : '' }}">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                                <path d="M16 4.41L14.59 3 6 11.59 2.41 8 1 9.41l5 5z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @elseif($answer->is_accepted)
                                    <div class="vote-check accepted">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                            <path d="M16 4.41L14.59 3 6 11.59 2.41 8 1 9.41l5 5z"/>
                                        </svg>
                                    </div>
                                @endif
                            @endauth
                        </div>
                        
                        {{-- Content Column --}}
                        <div class="post-content">
                            @if($answer->is_accepted)
                                <div class="badge badge-accepted">
                                    <svg width="14" height="14" viewBox="0 0 18 18" fill="currentColor">
                                        <path d="M16 4.41L14.59 3 6 11.59 2.41 8 1 9.41l5 5z"/>
                                    </svg>
                                    Réponse acceptée
                                </div>
                            @endif
                            
                            <div class="post-body">{{ $answer->body }}</div>
                            
                            {{-- Footer --}}
                            <div class="post-footer">
                                <div class="post-actions">
                                    <button class="post-action-btn">Partager</button>
                                    
                                    @auth
                                        @if(auth()->user()->isModerator())
                                            <form method="POST" action="{{ route('answers.destroy', $answer) }}" style="display:inline;"
                                                  onsubmit="return confirm('Supprimer cette réponse ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="mod-btn mod-btn-danger">Supprimer</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                
                                {{-- User Card --}}
                                <div class="user-card">
                                    <div class="user-card-time">répondu {{ $answer->created_at->diffForHumans() }}</div>
                                    <div class="user-card-info">
                                        <div class="user-avatar" style="background:{{ $colors[$answerColorIndex] }};">
                                            {{ strtoupper(substr($answer->user->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div class="user-details">
                                            <a href="#" class="user-name">{{ $answer->user->name }}</a>
                                            <div class="user-rep">{{ number_format($answer->user->reputation ?? 0) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            
            {{-- ══════════ ANSWER FORM ══════════ --}}
            @auth
                @if(!$question->is_closed)
                    <div class="answer-form">
                        <h2 class="answer-form-title">Votre réponse</h2>
                        <form action="{{ route('answers.store', $question) }}" method="POST">
                            @csrf
                            <textarea name="body" class="answer-textarea" 
                                      placeholder="Rédigez votre réponse ici..." 
                                      required>{{ old('body') }}</textarea>
                            @error('body')
                                <p style="color:#d93025;font-size:13px;margin-top:6px;">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="answer-submit">Publier votre réponse</button>
                        </form>
                    </div>
                @else
                    <div style="padding:16px;background:#f8f9f9;border:1px solid #e3e6e8;border-radius:3px;margin-top:24px;">
                        <p style="font-size:13px;color:#6a737c;margin:0;">
                            🔒 Cette question est fermée. Les nouvelles réponses ne sont pas acceptées.
                        </p>
                    </div>
                @endif
            @else
                <div style="padding:24px;background:#f8f9f9;border:1px solid #e3e6e8;border-radius:3px;margin-top:24px;text-align:center;">
                    <p style="font-size:15px;color:#232629;margin:0 0 12px;">
                        Vous devez être connecté pour répondre à cette question.
                    </p>
                    <div style="display:flex;justify-content:center;gap:8px;">
                        <a href="{{ route('login') }}" 
                           style="padding:10px 12px;font-size:13px;background:#0a95ff;color:#fff;
                                  border-radius:3px;text-decoration:none;">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" 
                           style="padding:10px 12px;font-size:13px;background:#fff;color:#0a95ff;
                                  border:1px solid #0a95ff;border-radius:3px;text-decoration:none;">
                            S'inscrire
                        </a>
                    </div>
                </div>
            @endauth
            
        </div>
        
        {{-- ══════════ SIDEBAR ══════════ --}}
        <aside>
            
            {{-- Ask Question Button --}}
            <a href="{{ route('questions.create') }}" 
               style="display:block;width:100%;padding:10px 12px;font-size:13px;font-weight:400;
                      background:#0a95ff;color:#fff;border-radius:3px;text-align:center;
                      text-decoration:none;margin-bottom:16px;">
                Poser une question
            </a>
            
            {{-- Guidelines Widget --}}
            <div class="sidebar-widget">
                <div class="sidebar-widget-title">📋 Règles de la communauté</div>
                <div class="sidebar-widget-body">
                    <ul style="margin:0;padding-left:18px;line-height:1.6;">
                        <li>Soyez respectueux et courtois</li>
                        <li>Votez pour les bonnes réponses</li>
                        <li>Acceptez la meilleure réponse</li>
                        <li>Évitez les doublons</li>
                    </ul>
                </div>
            </div>
            
            {{-- Stats Widget --}}
            <div class="sidebar-stats">
                <div style="font-size:12px;font-weight:700;color:#6a737c;margin-bottom:8px;text-transform:uppercase;">
                    Statistiques
                </div>
                <div class="sidebar-stat">
                    <span class="sidebar-stat-label">Questions</span>
                    <span class="sidebar-stat-value">{{ number_format(\App\Models\Question::count()) }}</span>
                </div>
                <div class="sidebar-stat">
                    <span class="sidebar-stat-label">Réponses</span>
                    <span class="sidebar-stat-value">{{ number_format(\App\Models\Answer::count()) }}</span>
                </div>
                <div class="sidebar-stat">
                    <span class="sidebar-stat-label">Utilisateurs</span>
                    <span class="sidebar-stat-value">{{ number_format(\App\Models\User::count()) }}</span>
                </div>
                <div class="sidebar-stat" style="border-top:1px solid #e3e6e8;margin-top:8px;padding-top:8px;">
                    <span class="sidebar-stat-label">Résolues</span>
                    <span class="sidebar-stat-value" style="color:#5eba7d;">
                        {{ number_format(\App\Models\Question::where('is_solved', true)->count()) }}
                    </span>
                </div>
            </div>
            
        </aside>
        
    </div>
    
</div>

</x-app-layout>
