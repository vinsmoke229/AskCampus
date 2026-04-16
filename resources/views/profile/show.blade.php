<x-app-layout>

{{-- ══════════════════════════════════════════
     USER PROFILE PAGE - Stack Overflow Style
══════════════════════════════════════════ --}}

<style>
    /* Container */
    .profile-container { max-width: 1264px; margin: 0 auto; }
    
    /* Profile Header */
    .profile-header { 
        display: flex; gap: 24px; align-items: flex-start;
        padding: 16px 0; margin-bottom: 16px;
    }
    .profile-avatar { 
        width: 128px; height: 128px; border-radius: 5px;
        display: flex; align-items: center; justify-content: center;
        font-size: 48px; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }
    .profile-info { flex: 1; }
    .profile-name { font-size: 34px; font-weight: 400; color: #232629; margin: 0 0 8px; }
    .profile-meta { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
    .profile-meta-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #6a737c; }
    .profile-meta-item svg { width: 16px; height: 16px; }
    .profile-actions { display: flex; gap: 8px; margin-top: 12px; }
    .profile-btn { 
        padding: 8px 12px; font-size: 13px; font-weight: 400;
        background: #fff; color: #6a737c; border: 1px solid #babfc4;
        border-radius: 3px; cursor: pointer; transition: background 0.1s;
    }
    .profile-btn:hover { background: #f8f9f9; }
    
    /* Tabs */
    .profile-tabs { 
        display: flex; gap: 0; border-bottom: 1px solid #e3e6e8;
        margin-bottom: 16px;
    }
    .profile-tab { 
        padding: 12px 16px; font-size: 13px; color: #6a737c;
        background: transparent; border: none; cursor: pointer;
        border-bottom: 2px solid transparent; transition: all 0.1s;
    }
    .profile-tab:hover { background: #f8f9f9; }
    .profile-tab.active { 
        color: #232629; font-weight: 700;
        border-bottom-color: #f48225;
    }
    
    /* Content Grid */
    .profile-grid { display: grid; grid-template-columns: 200px 1fr 300px; gap: 24px; }
    
    /* Sidebar Menu */
    .profile-sidebar { }
    .profile-menu { list-style: none; margin: 0; padding: 0; }
    .profile-menu-item { 
        padding: 8px 12px; font-size: 13px; color: #6a737c;
        cursor: pointer; border-radius: 3px; margin-bottom: 2px;
    }
    .profile-menu-item:hover { background: #f8f9f9; }
    .profile-menu-item.active { 
        background: #f48225; color: #fff; font-weight: 700;
    }
    
    /* Main Content */
    .profile-main { }
    .profile-section { margin-bottom: 24px; }
    .profile-section-title { font-size: 21px; font-weight: 400; color: #232629; margin: 0 0 16px; }
    
    /* Stats Cards */
    .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .stat-card { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 16px; text-align: center;
    }
    .stat-card-icon { 
        width: 48px; height: 48px; margin: 0 auto 12px;
        display: flex; align-items: center; justify-content: center;
        color: #9fa6ad;
    }
    .stat-card-title { font-size: 17px; font-weight: 400; color: #232629; margin-bottom: 8px; }
    .stat-card-desc { font-size: 13px; color: #6a737c; line-height: 1.5; }
    .stat-card-link { font-size: 13px; color: #0074cc; margin-top: 8px; display: inline-block; }
    .stat-card-link:hover { color: #0a95ff; }
    
    /* Reputation Card */
    .reputation-card { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 24px; text-align: center; margin-bottom: 16px;
    }
    .reputation-value { font-size: 48px; font-weight: 400; color: #232629; margin-bottom: 8px; }
    .reputation-label { font-size: 13px; color: #6a737c; margin-bottom: 16px; }
    .reputation-desc { font-size: 13px; color: #6a737c; line-height: 1.5; }
    .reputation-link { font-size: 13px; color: #0074cc; }
    .reputation-link:hover { color: #0a95ff; }
    
    /* Badges */
    .badges-section { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 16px;
    }
    .badges-header { 
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 12px;
    }
    .badges-title { font-size: 17px; font-weight: 400; color: #232629; }
    .badges-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .badge-card { 
        text-align: center; padding: 12px;
        border: 1px solid #e3e6e8; border-radius: 3px;
    }
    .badge-icon { 
        width: 32px; height: 32px; border-radius: 50%;
        margin: 0 auto 8px; display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700; color: #fff;
    }
    .badge-name { font-size: 13px; color: #232629; margin-bottom: 4px; }
    .badge-progress { font-size: 11px; color: #6a737c; }
    
    /* Activity List */
    .activity-list { }
    .activity-item { 
        padding: 16px; border: 1px solid #e3e6e8; border-radius: 3px;
        margin-bottom: 8px; background: #fff;
    }
    .activity-item:hover { background: #fafafa; }
    .activity-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
    .activity-type { font-size: 12px; color: #6a737c; text-transform: uppercase; }
    .activity-date { font-size: 12px; color: #9fa6ad; }
    .activity-title { font-size: 15px; color: #0074cc; margin-bottom: 8px; }
    .activity-title:hover { color: #0a95ff; }
    .activity-stats { display: flex; gap: 12px; font-size: 12px; color: #6a737c; }
    
    /* Right Sidebar */
    .profile-aside { }
    .aside-widget { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 12px; margin-bottom: 16px;
    }
    .aside-widget-title { font-size: 12px; font-weight: 700; color: #6a737c; margin-bottom: 12px; text-transform: uppercase; }
    .aside-stat { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
    .aside-stat-label { color: #6a737c; }
    .aside-stat-value { color: #232629; font-weight: 700; }
</style>

@php
    $user = auth()->user();
    $colors = ['#0074cc','#5eba7d','#f48225','#d93025','#8b5cf6','#0891b2'];
    $colorIndex = abs(crc32($user->name)) % count($colors);
    
    $userQuestions = $user->questions()->count();
    $userAnswers = $user->answers()->count();
    $acceptedAnswers = $user->answers()->where('is_accepted', true)->count();
    $userReputation = $user->reputation ?? 0;
    
    // Calculer depuis quand l'utilisateur est membre
    $memberSince = $user->created_at->diffForHumans();
    $memberDays = $user->created_at->diffInDays(now());
    
    // Dernière visite (simulé)
    $lastSeen = 'cette semaine';
    
    // Activité récente
    $recentActivity = collect([]);
    
    // Ajouter les questions récentes
    foreach($user->questions()->latest()->take(5)->get() as $q) {
        $recentActivity->push([
            'type' => 'question',
            'title' => $q->title,
            'url' => route('questions.show', $q),
            'date' => $q->created_at,
            'votes' => $q->vote_score,
            'answers' => $q->answers->count(),
            'views' => $q->views,
        ]);
    }
    
    // Ajouter les réponses récentes
    foreach($user->answers()->latest()->take(5)->get() as $a) {
        $recentActivity->push([
            'type' => 'answer',
            'title' => $a->question->title ?? 'Question supprimée',
            'url' => route('questions.show', $a->question),
            'date' => $a->created_at,
            'votes' => $a->votes->sum('value'),
            'accepted' => $a->is_accepted,
        ]);
    }
    
    // Trier par date
    $recentActivity = $recentActivity->sortByDesc('date')->take(10);
@endphp

<div class="profile-container">
    
    {{-- ══════════ PROFILE HEADER ══════════ --}}
    <div class="profile-header">
        <div class="profile-avatar" style="background:{{ $colors[$colorIndex] }};">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="profile-info">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <div class="profile-meta">
                <div class="profile-meta-item">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                        <path d="M8 3.5a.5.5 0 01.5.5v4a.5.5 0 01-.5.5H5.5a.5.5 0 010-1H7.5V4a.5.5 0 01.5-.5z"/>
                    </svg>
                    Membre depuis {{ $memberDays }} jours
                </div>
                <div class="profile-meta-item">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                    </svg>
                    Vu {{ $lastSeen }}
                </div>
                <div class="profile-meta-item">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                    </svg>
                    Visité {{ $memberDays }} jours, {{ $memberDays }} consécutifs
                </div>
            </div>
            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="profile-btn">
                    <svg style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:4px;" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 01.708 0l3 3a.5.5 0 010 .708l-10 10a.5.5 0 01-.168.11l-5 2a.5.5 0 01-.65-.65l2-5a.5.5 0 01.11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 01.5.5v.5h.5a.5.5 0 01.5.5v.5h.293l6.5-6.5z"/>
                    </svg>
                    Modifier le profil
                </a>
                <button class="profile-btn">
                    <svg style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:4px;" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                    </svg>
                    Profil réseau
                </button>
            </div>
        </div>
    </div>
    
    {{-- ══════════ TABS ══════════ --}}
    <div class="profile-tabs">
        <button class="profile-tab">Profil</button>
        <button class="profile-tab active">Activité</button>
        <button class="profile-tab">Sauvegardes</button>
        <button class="profile-tab">Paramètres</button>
    </div>
    
    {{-- ══════════ CONTENT GRID ══════════ --}}
    <div class="profile-grid">
        
        {{-- Left Sidebar Menu --}}
        <aside class="profile-sidebar">
            <div style="font-size:12px;font-weight:700;color:#6a737c;margin-bottom:8px;text-transform:uppercase;">
                Résumé
            </div>
            <ul class="profile-menu">
                <li class="profile-menu-item active">Réponses</li>
                <li class="profile-menu-item">Questions</li>
                <li class="profile-menu-item">Tags</li>
                <li class="profile-menu-item">Articles</li>
                <li class="profile-menu-item">Badges</li>
                <li class="profile-menu-item">Abonnements</li>
                <li class="profile-menu-item">Primes</li>
                <li class="profile-menu-item">Réputation</li>
                <li class="profile-menu-item">Toutes les actions</li>
                <li class="profile-menu-item">Réponses</li>
                <li class="profile-menu-item">Votes</li>
            </ul>
        </aside>
        
        {{-- Main Content --}}
        <main class="profile-main">
            
            {{-- Summary Section --}}
            <div class="profile-section">
                <h2 class="profile-section-title">Résumé</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-icon">
                            <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                            </svg>
                        </div>
                        <h3 class="stat-card-title">La réputation, c'est comment la communauté vous remercie</h3>
                        <p class="stat-card-desc">
                            Lorsque les utilisateurs votent pour vos publications utiles, vous gagnez de la réputation et débloquez de nouveaux privilèges.
                        </p>
                        <a href="#" class="stat-card-link">En savoir plus sur la réputation et les privilèges</a>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-card-icon">
                            <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                            </svg>
                        </div>
                        <h3 class="stat-card-title">Mesurez votre impact</h3>
                        <p class="stat-card-desc">
                            Vos publications et votre aide aident ici des centaines ou des milliers de personnes à la recherche d'aide.
                        </p>
                    </div>
                </div>
            </div>
            
            {{-- Answers Section --}}
            <div class="profile-section">
                <h2 class="profile-section-title">Réponses</h2>
                
                @if($userAnswers > 0)
                    <div class="activity-list">
                        @foreach($recentActivity->where('type', 'answer') as $activity)
                            <div class="activity-item">
                                <div class="activity-header">
                                    <span class="activity-type">Réponse</span>
                                    <span class="activity-date">{{ $activity['date']->diffForHumans() }}</span>
                                </div>
                                <a href="{{ $activity['url'] }}" class="activity-title">
                                    {{ $activity['title'] }}
                                </a>
                                <div class="activity-stats">
                                    <span>{{ $activity['votes'] }} votes</span>
                                    @if($activity['accepted'])
                                        <span style="color:#5eba7d;">✓ Acceptée</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align:center;padding:48px;background:#f8f9f9;border:1px solid #e3e6e8;border-radius:3px;">
                        <p style="font-size:15px;color:#6a737c;margin:0;">
                            Vous n'avez pas encore répondu à des questions.
                        </p>
                    </div>
                @endif
            </div>
            
            {{-- Questions Section --}}
            <div class="profile-section">
                <h2 class="profile-section-title">Questions</h2>
                
                @if($userQuestions > 0)
                    <div class="activity-list">
                        @foreach($recentActivity->where('type', 'question') as $activity)
                            <div class="activity-item">
                                <div class="activity-header">
                                    <span class="activity-type">Question</span>
                                    <span class="activity-date">{{ $activity['date']->diffForHumans() }}</span>
                                </div>
                                <a href="{{ $activity['url'] }}" class="activity-title">
                                    {{ $activity['title'] }}
                                </a>
                                <div class="activity-stats">
                                    <span>{{ $activity['votes'] }} votes</span>
                                    <span>{{ $activity['answers'] }} réponses</span>
                                    <span>{{ $activity['views'] }} vues</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align:center;padding:48px;background:#f8f9f9;border:1px solid #e3e6e8;border-radius:3px;">
                        <p style="font-size:15px;color:#6a737c;margin:0;">
                            Vous n'avez pas encore posé de questions.
                        </p>
                    </div>
                @endif
            </div>
            
        </main>
        
        {{-- Right Sidebar --}}
        <aside class="profile-aside">
            
            {{-- Reputation Card --}}
            <div class="reputation-card">
                <div class="reputation-value">{{ number_format($userReputation) }}</div>
                <div class="reputation-label">RÉPUTATION</div>
                <p class="reputation-desc">
                    Gagnez de la réputation en 
                    <a href="#" class="reputation-link">Posant</a>, 
                    <a href="#" class="reputation-link">Répondant</a> & 
                    <a href="#" class="reputation-link">Éditant</a>.
                </p>
            </div>
            
            {{-- Badges Section --}}
            <div class="badges-section">
                <div class="badges-header">
                    <h3 class="badges-title">Badges</h3>
                    <a href="#" style="font-size:13px;color:#0074cc;">Voir tous</a>
                </div>
                <div class="badges-grid">
                    <div class="badge-card">
                        <div class="badge-icon" style="background:#cd7f32;">●</div>
                        <div class="badge-name">Informé</div>
                        <div class="badge-progress">0/1</div>
                    </div>
                    <div class="badge-card">
                        <div class="badge-icon" style="background:#f48225;">★</div>
                        <div class="badge-name">Autobiographe</div>
                        <div class="badge-progress">0/1</div>
                    </div>
                </div>
            </div>
            
            {{-- Stats Widget --}}
            <div class="aside-widget" style="margin-top:16px;">
                <div class="aside-widget-title">Statistiques</div>
                <div class="aside-stat">
                    <span class="aside-stat-label">Questions</span>
                    <span class="aside-stat-value">{{ $userQuestions }}</span>
                </div>
                <div class="aside-stat">
                    <span class="aside-stat-label">Réponses</span>
                    <span class="aside-stat-value">{{ $userAnswers }}</span>
                </div>
                <div class="aside-stat">
                    <span class="aside-stat-label">Acceptées</span>
                    <span class="aside-stat-value" style="color:#5eba7d;">{{ $acceptedAnswers }}</span>
                </div>
            </div>
            
        </aside>
        
    </div>
    
</div>

</x-app-layout>
