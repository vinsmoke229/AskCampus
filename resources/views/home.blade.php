<x-app-layout>

{{-- ══════════════════════════════════════════
     HOME PAGE - Stack Overflow Style
══════════════════════════════════════════ --}}

<style>
    /* Container */
    .home-container { max-width: 1264px; margin: 0 auto; }
    .home-grid { display: grid; grid-template-columns: 1fr 300px; gap: 24px; }
    
    /* Welcome Section */
    .welcome-section { 
        background: linear-gradient(90deg, #f8f9f9 0%, #fff 100%);
        border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 16px; margin-bottom: 16px;
    }
    .welcome-title { font-size: 21px; font-weight: 400; color: #232629; margin: 0 0 4px; }
    .welcome-subtitle { font-size: 13px; color: #6a737c; margin: 0 0 12px; }
    .welcome-input { 
        width: 100%; padding: 10px 12px; font-size: 13px;
        border: 1px solid #babfc4; border-radius: 3px;
        color: #232629; outline: none;
    }
    .welcome-input:focus { border-color: #6cbbf7; box-shadow: 0 0 0 4px rgba(0,149,255,0.15); }
    .welcome-note { font-size: 12px; color: #6a737c; margin-top: 8px; }
    
    /* Stats Cards */
    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 16px; }
    .stat-card { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 12px; display: flex; flex-direction: column; gap: 4px;
    }
    .stat-card-title { font-size: 12px; color: #6a737c; font-weight: 700; text-transform: uppercase; }
    .stat-card-value { font-size: 24px; font-weight: 400; color: #232629; }
    .stat-card-link { font-size: 12px; color: #0074cc; margin-top: 4px; }
    .stat-card-link:hover { color: #0a95ff; }
    
    /* Badge Progress */
    .badge-section { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 12px; margin-bottom: 16px;
    }
    .badge-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .badge-title { font-size: 15px; font-weight: 400; color: #232629; }
    .badge-item { 
        display: flex; justify-content: space-between; align-items: center;
        padding: 8px 0; border-bottom: 1px solid #f8f9f9;
    }
    .badge-item:last-child { border-bottom: none; }
    .badge-name { font-size: 13px; color: #232629; }
    .badge-progress { font-size: 12px; color: #6a737c; }
    .badge-icon { 
        width: 24px; height: 24px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700;
    }
    
    /* Watched Tags */
    .watched-tags { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 12px; margin-bottom: 16px;
    }
    .watched-tags-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .watched-tags-title { font-size: 15px; font-weight: 400; color: #232629; }
    .tags-list { display: flex; flex-wrap: wrap; gap: 6px; }
    .tag-item { 
        padding: 4px 6px; font-size: 12px; background: #e1ecf4; color: #39739d;
        border-radius: 3px; text-decoration: none;
    }
    .tag-item:hover { background: #d0e3f1; }
    .tag-add { 
        padding: 4px 8px; font-size: 12px; color: #6a737c;
        border: 1px dashed #babfc4; border-radius: 3px; cursor: pointer;
    }
    .tag-add:hover { background: #f8f9f9; }
    
    /* Posts Section */
    .posts-section { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
    }
    .posts-header { 
        padding: 12px 16px; border-bottom: 1px solid #e3e6e8;
        display: flex; justify-content: space-between; align-items: center;
    }
    .posts-title { font-size: 17px; font-weight: 400; color: #232629; }
    .posts-subtitle { font-size: 12px; color: #6a737c; margin-top: 2px; }
    .posts-link { font-size: 13px; color: #0074cc; }
    .posts-link:hover { color: #0a95ff; }
    
    /* Post Item */
    .post-item { 
        padding: 16px; border-bottom: 1px solid #f8f9f9;
        display: flex; gap: 16px;
    }
    .post-item:last-child { border-bottom: none; }
    .post-item:hover { background: #fafafa; }
    
    .post-stats { display: flex; gap: 12px; flex-shrink: 0; }
    .post-stat { 
        display: flex; flex-direction: column; align-items: center;
        min-width: 48px; padding: 4px;
    }
    .post-stat-value { font-size: 13px; font-weight: 400; color: #6a737c; }
    .post-stat-label { font-size: 11px; color: #9fa6ad; }
    .post-stat.has-answer { color: #5eba7d; }
    .post-stat.has-answer .post-stat-value { 
        color: #fff; background: #5eba7d; 
        padding: 4px 8px; border-radius: 3px; font-weight: 700;
    }
    .post-stat.answered { border: 1px solid #5eba7d; border-radius: 3px; }
    .post-stat.answered .post-stat-value { color: #5eba7d; font-weight: 700; }
    
    .post-content { flex: 1; min-width: 0; }
    .post-title { 
        font-size: 15px; font-weight: 400; color: #0074cc;
        margin: 0 0 8px; line-height: 1.4;
    }
    .post-title:hover { color: #0a95ff; }
    .post-excerpt { font-size: 13px; color: #3b4045; line-height: 1.5; margin-bottom: 8px; }
    .post-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .post-tags { display: flex; gap: 4px; flex-wrap: wrap; }
    .post-tag { 
        padding: 3px 6px; font-size: 11px; background: #e1ecf4; color: #39739d;
        border-radius: 3px; text-decoration: none;
    }
    .post-tag:hover { background: #d0e3f1; }
    .post-author { 
        display: flex; align-items: center; gap: 4px;
        font-size: 12px; color: #6a737c; margin-left: auto;
    }
    .post-author-avatar { 
        width: 16px; height: 16px; border-radius: 2px;
        display: flex; align-items: center; justify-content: center;
        font-size: 9px; font-weight: 700; color: #fff;
    }
    .post-author-name { color: #0074cc; }
    .post-author-name:hover { color: #0a95ff; }
    .post-author-rep { color: #6a737c; font-weight: 700; }
    
    /* Sidebar */
    .sidebar-widget { 
        background: #fdf7e2; border: 1px solid #f1e5bc; border-radius: 3px;
        padding: 12px; margin-bottom: 16px;
    }
    .sidebar-widget-title { font-size: 12px; font-weight: 700; color: #3b4045; margin-bottom: 8px; }
    .sidebar-widget-body { font-size: 13px; color: #3b4045; line-height: 1.5; }
    .sidebar-list { margin: 0; padding: 0; list-style: none; }
    .sidebar-list li { padding: 6px 0; font-size: 13px; color: #3b4045; }
    .sidebar-list li a { color: #0074cc; text-decoration: none; }
    .sidebar-list li a:hover { color: #0a95ff; }
    
    .sidebar-stats { background: #fff; border: 1px solid #e3e6e8; border-radius: 3px; padding: 12px; }
    .sidebar-stat { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
    .sidebar-stat-label { color: #6a737c; }
    .sidebar-stat-value { color: #232629; font-weight: 700; }
</style>

@php
    $user = auth()->user();
    $userQuestions = $user->questions()->count();
    $userAnswers = $user->answers()->count();
    $userReputation = $user->reputation ?? 0;
    
    // Badge progress (exemple)
    $nextBadge = 'Autobiographe';
    $badgeProgress = '0/1';
    
    // Tags suivis (exemple - à adapter selon votre logique)
    $watchedTags = $user->questions()
        ->with('tags')
        ->get()
        ->pluck('tags')
        ->flatten()
        ->unique('id')
        ->take(6);
    
    // Questions recommandées basées sur les tags de l'utilisateur
    $recommendedQuestions = \App\Models\Question::with(['user', 'tags', 'answers'])
        ->latest()
        ->take(10)
        ->get();
    
    $colors = ['#0074cc','#5eba7d','#f48225','#d93025','#8b5cf6','#0891b2'];
@endphp

<div class="home-container">
    
    {{-- Welcome Section --}}
    <div class="welcome-section">
        <h1 class="welcome-title">Hey {{ $user->name }}, what do you want to learn today?</h1>
        <p class="welcome-subtitle">Obtenez des réponses instantanées avec AI Assist, basées sur les connaissances vérifiées de la communauté.</p>
        <input type="text" class="welcome-input" placeholder="Commencez une discussion avec AI Assist...">
        <p class="welcome-note">
            En utilisant AI Assist, vous acceptez les 
            <a href="#" style="color:#0074cc;">Conditions d'utilisation</a> et la 
            <a href="#" style="color:#0074cc;">Politique de confidentialité</a> de AskCampus.
        </p>
    </div>
    
    <div class="home-grid">
        
        {{-- Main Content --}}
        <div>
            
            {{-- Stats Row --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-card-title">Réputation</div>
                    <div class="stat-card-value">{{ number_format($userReputation) }}</div>
                    <a href="{{ route('dashboard') }}" class="stat-card-link">
                        Gagnez de la réputation en 
                        <strong>Posant</strong>, <strong>Répondant</strong> & <strong>Éditant</strong>.
                    </a>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-title">Progression des badges</div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
                        <div class="badge-icon" style="background:#f48225;color:#fff;">
                            {{ $badgeProgress }}
                        </div>
                        <div>
                            <div style="font-size:13px;color:#232629;">{{ $nextBadge }}</div>
                            <div style="font-size:12px;color:#6a737c;">Complétez la section "À propos" de votre profil.</div>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-title">Tags suivis</div>
                    <div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:4px;">
                        @forelse($watchedTags as $tag)
                            <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="tag-item">
                                {{ $tag->name }}
                            </a>
                        @empty
                            <span style="font-size:12px;color:#6a737c;">Aucun tag suivi</span>
                        @endforelse
                        <a href="#" class="tag-add">+ Ajouter</a>
                    </div>
                    <a href="#" class="stat-card-link" style="margin-top:8px;">Personnalisez votre flux</a>
                </div>
            </div>
            
            {{-- Interesting Posts --}}
            <div class="posts-section">
                <div class="posts-header">
                    <div>
                        <h2 class="posts-title">Publications intéressantes pour vous</h2>
                        <p class="posts-subtitle">
                            Basé sur votre historique de navigation et vos tags suivis. 
                            <a href="#" style="color:#0074cc;">Personnalisez votre flux</a>
                        </p>
                    </div>
                </div>
                
                @foreach($recommendedQuestions as $question)
                    @php
                        $answerCount = $question->answers->count();
                        $colorIndex = abs(crc32($question->user->name ?? '')) % count($colors);
                    @endphp
                    
                    <div class="post-item">
                        {{-- Stats --}}
                        <div class="post-stats">
                            <div class="post-stat">
                                <div class="post-stat-value">{{ $question->vote_score }}</div>
                                <div class="post-stat-label">votes</div>
                            </div>
                            
                            @if($question->is_solved)
                                <div class="post-stat has-answer">
                                    <div class="post-stat-value">✓ {{ $answerCount }}</div>
                                    <div class="post-stat-label" style="color:#5eba7d;">réponses</div>
                                </div>
                            @elseif($answerCount > 0)
                                <div class="post-stat answered">
                                    <div class="post-stat-value">{{ $answerCount }}</div>
                                    <div class="post-stat-label">réponses</div>
                                </div>
                            @else
                                <div class="post-stat">
                                    <div class="post-stat-value">{{ $answerCount }}</div>
                                    <div class="post-stat-label">réponses</div>
                                </div>
                            @endif
                            
                            <div class="post-stat">
                                <div class="post-stat-value">{{ $question->views }}</div>
                                <div class="post-stat-label">vues</div>
                            </div>
                        </div>
                        
                        {{-- Content --}}
                        <div class="post-content">
                            <h3>
                                <a href="{{ route('questions.show', $question) }}" class="post-title">
                                    {{ $question->title }}
                                </a>
                            </h3>
                            
                            <div class="post-excerpt">
                                {{ Str::limit(strip_tags($question->body), 150) }}
                            </div>
                            
                            <div class="post-meta">
                                <div class="post-tags">
                                    @foreach($question->tags as $tag)
                                        <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="post-tag">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                                
                                <div class="post-author">
                                    <div class="post-author-avatar" style="background:{{ $colors[$colorIndex] }};">
                                        {{ strtoupper(substr($question->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <a href="#" class="post-author-name">{{ $question->user->name }}</a>
                                    <span class="post-author-rep">{{ number_format($question->user->reputation ?? 0) }}</span>
                                    <span style="color:#9fa6ad;">posé {{ $question->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
            
        </div>
        
        {{-- Sidebar --}}
        <aside>
            
            {{-- Blog Widget --}}
            <div class="sidebar-widget">
                <div class="sidebar-widget-title">📝 Le Blog AskCampus</div>
                <ul class="sidebar-list">
                    <li><a href="#">Comment bien poser une question</a></li>
                    <li><a href="#">Système de réputation expliqué</a></li>
                    <li><a href="#">Guide du modérateur</a></li>
                </ul>
            </div>
            
            {{-- Featured Widget --}}
            <div class="sidebar-widget" style="background:#e1ecf4;border-color:#c8dae9;">
                <div class="sidebar-widget-title">⭐ Mis en avant sur Meta</div>
                <ul class="sidebar-list">
                    <li><a href="#">Retirer le site bêta</a></li>
                    <li><a href="#">Politique : IA générative (ChatGPT) est interdite</a></li>
                </ul>
            </div>
            
            {{-- Hot Posts Widget --}}
            <div class="sidebar-widget" style="background:#fff;border-color:#e3e6e8;">
                <div class="sidebar-widget-title">🔥 Publications populaires</div>
                <ul class="sidebar-list">
                    @foreach(\App\Models\Question::orderByDesc('views')->take(5)->get() as $hotQ)
                        <li>
                            <a href="{{ route('questions.show', $hotQ) }}">
                                {{ Str::limit($hotQ->title, 60) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            {{-- Community Activity --}}
            <div class="sidebar-stats">
                <div style="font-size:12px;font-weight:700;color:#6a737c;margin-bottom:8px;text-transform:uppercase;">
                    Activité de la communauté
                </div>
                <div class="sidebar-stat">
                    <span class="sidebar-stat-label">
                        <span style="color:#5eba7d;">●</span> 
                        {{ \App\Models\User::count() }} utilisateurs en ligne
                    </span>
                </div>
                <div class="sidebar-stat">
                    <span class="sidebar-stat-label">{{ \App\Models\Question::whereDate('created_at', today())->count() }} questions</span>
                </div>
            </div>
            
        </aside>
        
    </div>
    
</div>

</x-app-layout>
