<x-app-layout>
@php
    $user = auth()->user();
    $colors = ['#0074cc','#5eba7d','#f48225','#d93025','#8b5cf6','#0891b2'];
    $colorIndex = abs(crc32($user->name)) % count($colors);
    
    // Statistiques utilisateur
    $userQuestions = $user->questions()->withCount('answers', 'votes')->get();
    $userAnswers = $user->answers()->with('question')->withCount('votes')->get();
    $userTags = $user->questions()->with('tags')->get()->pluck('tags')->flatten()->groupBy('id');
    
    $stats = [
        'questions' => $userQuestions->count(),
        'answers' => $userAnswers->count(),
        'accepted' => $userAnswers->where('is_accepted', true)->count(),
        'reputation' => $user->reputation ?? 1,
        'reached' => $userQuestions->sum('views'),
        'tags' => $userTags->count(),
    ];
    
    // Votes donnés par l'utilisateur
    $userVotes = $user->votes()->with('votable')->latest()->take(20)->get();
    $upvotes = $user->votes()->where('value', 1)->count();
    $downvotes = $user->votes()->where('value', -1)->count();
    
    // Dates
    $memberSince = $user->created_at->format('M Y');
    $memberDays = $user->created_at->diffInDays(now());
    $lastSeen = 'cette semaine';
@endphp

<style>
/* ═══ CONTAINER ═══ */
.prof-wrap { max-width:1264px; margin:0 auto; padding:16px 0; }

/* ═══ HEADER ═══ */
.prof-head { display:flex; gap:24px; padding-bottom:16px; margin-bottom:16px; }
.prof-avatar { 
    width:128px; height:128px; border-radius:5px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:48px; font-weight:700; color:#fff;
}
.prof-info { flex:1; }
.prof-name { font-size:34px; font-weight:400; color:#232629; margin:0 0 8px; line-height:1.2; }
.prof-meta { display:flex; gap:16px; flex-wrap:wrap; font-size:13px; color:#6a737c; margin-bottom:12px; }
.prof-meta-item { display:flex; align-items:center; gap:6px; }
.prof-meta svg { width:16px; height:16px; }
.prof-actions { display:flex; gap:8px; }
.prof-btn { 
    padding:8px 12px; font-size:13px; background:#fff; color:#6a737c;
    border:1px solid #babfc4; border-radius:3px; cursor:pointer;
    transition:background .1s; display:inline-flex; align-items:center; gap:6px;
}
.prof-btn:hover { background:#f8f9f9; }
.prof-btn svg { width:14px; height:14px; }

/* ═══ TABS ═══ */
.prof-tabs { 
    display:flex; border-bottom:1px solid #e3e6e8; margin-bottom:16px;
    position:sticky; top:52px; background:#fff; z-index:10;
}
.prof-tab { 
    padding:12px 16px; font-size:13px; color:#6a737c; background:transparent;
    border:none; cursor:pointer; border-bottom:2px solid transparent;
    transition:all .1s;
}
.prof-tab:hover { background:#f8f9f9; }
.prof-tab.active { color:#232629; font-weight:700; border-bottom-color:#f48225; }

/* ═══ LAYOUT GRID ═══ */
.prof-grid { display:grid; grid-template-columns:200px 1fr 300px; gap:24px; }

/* ═══ LEFT SIDEBAR ═══ */
.prof-sidebar { }
.prof-sidebar-title { 
    font-size:12px; font-weight:700; color:#6a737c; margin-bottom:8px;
    text-transform:uppercase; letter-spacing:0.5px;
}
.prof-menu { list-style:none; margin:0; padding:0; }
.prof-menu-item { 
    padding:8px 12px; font-size:13px; color:#6a737c; cursor:pointer;
    border-radius:3px; margin-bottom:2px; transition:all .1s;
}
.prof-menu-item:hover { background:#f8f9f9; }
.prof-menu-item.active { background:#f48225; color:#fff; font-weight:700; }

/* ═══ MAIN CONTENT ═══ */
.prof-main { min-height:400px; }
.prof-section { margin-bottom:32px; }
.prof-section-title { font-size:21px; font-weight:400; color:#232629; margin:0 0 16px; }

/* ═══ STATS GRID ═══ */
.stats-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; margin-bottom:24px; }
.stat-card { 
    background:#fff; border:1px solid #e3e6e8; border-radius:3px;
    padding:20px; text-align:center;
}
.stat-icon { 
    width:48px; height:48px; margin:0 auto 12px;
    display:flex; align-items:center; justify-content:center; color:#9fa6ad;
}
.stat-icon svg { width:100%; height:100%; }
.stat-title { font-size:17px; font-weight:400; color:#232629; margin-bottom:8px; line-height:1.3; }
.stat-desc { font-size:13px; color:#6a737c; line-height:1.5; margin-bottom:12px; }
.stat-link { font-size:13px; color:#0074cc; }
.stat-link:hover { color:#0a95ff; }

/* ═══ ACTIVITY LIST ═══ */
.activity-list { }
.activity-item { 
    background:#fff; border:1px solid #e3e6e8; border-radius:3px;
    padding:16px; margin-bottom:8px; transition:background .1s;
}
.activity-item:hover { background:#fafafa; }
.activity-header { display:flex; justify-content:space-between; margin-bottom:8px; }
.activity-type { 
    font-size:11px; color:#6a737c; text-transform:uppercase;
    font-weight:700; letter-spacing:0.5px;
}
.activity-date { font-size:12px; color:#9fa6ad; }
.activity-title { 
    font-size:15px; color:#0074cc; margin-bottom:8px;
    display:block; text-decoration:none;
}
.activity-title:hover { color:#0a95ff; }
.activity-stats { display:flex; gap:12px; font-size:12px; color:#6a737c; }
.activity-stat { display:flex; align-items:center; gap:4px; }

/* ═══ TAGS GRID ═══ */
.tags-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; }
.tag-card { 
    background:#fff; border:1px solid #e3e6e8; border-radius:3px;
    padding:12px; transition:all .1s;
}
.tag-card:hover { border-color:#babfc4; box-shadow:0 2px 4px rgba(0,0,0,0.05); }
.tag-card-name { 
    display:inline-block; padding:4px 8px; font-size:12px; font-weight:600;
    background:#e1ecf4; color:#39739d; border-radius:3px; margin-bottom:8px;
}
.tag-card-stats { display:flex; gap:12px; font-size:12px; color:#6a737c; }

/* ═══ VOTES LIST ═══ */
.votes-list { }
.vote-item { 
    background:#fff; border:1px solid #e3e6e8; border-radius:3px;
    padding:12px 16px; margin-bottom:6px; display:flex; align-items:center; gap:12px;
}
.vote-badge { 
    width:32px; height:32px; border-radius:3px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:14px; font-weight:700;
}
.vote-badge.up { background:#d4edda; color:#155724; }
.vote-badge.down { background:#f8d7da; color:#721c24; }
.vote-content { flex:1; min-width:0; }
.vote-title { font-size:13px; color:#0074cc; }
.vote-title:hover { color:#0a95ff; }
.vote-date { font-size:11px; color:#9fa6ad; margin-top:2px; }

/* ═══ RIGHT SIDEBAR ═══ */
.prof-aside { }
.aside-card { 
    background:#fff; border:1px solid #e3e6e8; border-radius:3px;
    padding:16px; margin-bottom:16px;
}
.aside-title { font-size:12px; font-weight:700; color:#6a737c; margin-bottom:12px; text-transform:uppercase; }

/* Reputation Card */
.rep-card { text-align:center; padding:24px 16px; }
.rep-value { font-size:48px; font-weight:400; color:#232629; margin-bottom:8px; line-height:1; }
.rep-label { font-size:13px; color:#6a737c; margin-bottom:16px; font-weight:700; }
.rep-desc { font-size:13px; color:#6a737c; line-height:1.5; }
.rep-link { color:#0074cc; }
.rep-link:hover { color:#0a95ff; }

/* Badges */
.badges-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
.badges-title { font-size:15px; font-weight:400; color:#232629; }
.badges-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; }
.badge-item { 
    text-align:center; padding:12px 8px; border:1px solid #e3e6e8;
    border-radius:3px; transition:all .1s;
}
.badge-item:hover { border-color:#babfc4; }
.badge-icon { 
    width:32px; height:32px; border-radius:50%; margin:0 auto 8px;
    display:flex; align-items:center; justify-content:center;
    font-size:16px; font-weight:700; color:#fff;
}
.badge-name { font-size:12px; color:#232629; margin-bottom:4px; font-weight:600; }
.badge-progress { font-size:11px; color:#6a737c; }

/* Stats Widget */
.aside-stat { display:flex; justify-content:space-between; padding:6px 0; font-size:13px; }
.aside-stat-label { color:#6a737c; }
.aside-stat-value { color:#232629; font-weight:700; }

/* Empty State */
.empty-state { 
    text-align:center; padding:48px 24px; background:#f8f9f9;
    border:1px solid #e3e6e8; border-radius:3px;
}
.empty-icon { 
    width:64px; height:64px; margin:0 auto 16px;
    display:flex; align-items:center; justify-content:center; color:#d6d9dc;
}
.empty-icon svg { width:100%; height:100%; }
.empty-title { font-size:17px; color:#232629; margin-bottom:8px; }
.empty-desc { font-size:13px; color:#6a737c; line-height:1.5; }

/* Impact Stats */
.impact-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; margin-bottom:24px; }
.impact-card { 
    background:#fff; border:1px solid #e3e6e8; border-radius:3px;
    padding:16px; text-align:center;
}
.impact-value { font-size:32px; font-weight:400; color:#232629; margin-bottom:4px; }
.impact-label { font-size:13px; color:#6a737c; }
</style>

<div class="prof-wrap">
    
    {{-- ═══ HEADER ═══ --}}
    <div class="prof-head">
        <div class="prof-avatar" style="background:{{ $colors[$colorIndex] }};">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="prof-info">
            <h1 class="prof-name">{{ $user->name }}</h1>
            <div class="prof-meta">
                <div class="prof-meta-item">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                        <path d="M8 3.5a.5.5 0 01.5.5v4a.5.5 0 01-.5.5H5.5a.5.5 0 010-1H7.5V4a.5.5 0 01.5-.5z"/>
                    </svg>
                    Membre depuis {{ $memberDays }} jours
                </div>
                <div class="prof-meta-item">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                    </svg>
                    Vu {{ $lastSeen }}
                </div>
                <div class="prof-meta-item">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3 0h10a2 2 0 012 2v12a2 2 0 01-2 2H3a2 2 0 01-2-2V2a2 2 0 012-2zm0 1a1 1 0 00-1 1v12a1 1 0 001 1h10a1 1 0 001-1V2a1 1 0 00-1-1H3z"/>
                        <path d="M5 4h6v1H5V4zm0 3h6v1H5V7zm0 3h6v1H5v-1z"/>
                    </svg>
                    Visité {{ $memberDays }} jours, {{ $memberDays }} consécutifs
                </div>
            </div>
            <div class="prof-actions">
                <a href="{{ route('profile.edit') }}" class="prof-btn">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 01.708 0l3 3a.5.5 0 010 .708l-10 10a.5.5 0 01-.168.11l-5 2a.5.5 0 01-.65-.65l2-5a.5.5 0 01.11-.168l10-10z"/>
                    </svg>
                    Modifier le profil
                </a>
                <button class="prof-btn">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                    </svg>
                    Profil réseau
                </button>
            </div>
        </div>
    </div>
    
    {{-- ═══ TABS ═══ --}}
    <div class="prof-tabs">
        <button class="prof-tab active" data-tab="profile">Profil</button>
        <button class="prof-tab" data-tab="activity">Activité</button>
    </div>
    
    {{-- ═══ CONTENT GRID ═══ --}}
    <div class="prof-grid">
        
        {{-- ═══ ONGLET PROFIL ═══ --}}
        <div class="prof-tab-content" data-tab-content="profile">
            {{-- Pas de sidebar pour l'onglet Profil --}}
            <div></div>
            
            {{-- Main Content: Stats + About --}}
            <div style="grid-column:2;">
                
                {{-- Stats Section --}}
                <div class="prof-section">
                    <h2 class="prof-section-title">Stats</h2>
                    <div class="impact-grid">
                        <div class="impact-card">
                            <div class="impact-value">{{ $stats['reputation'] }}</div>
                            <div class="impact-label">réputation</div>
                        </div>
                        <div class="impact-card">
                            <div class="impact-value">{{ number_format($stats['reached']) }}</div>
                            <div class="impact-label">atteint</div>
                        </div>
                        <div class="impact-card">
                            <div class="impact-value">{{ $stats['answers'] }}</div>
                            <div class="impact-label">réponses</div>
                        </div>
                        <div class="impact-card">
                            <div class="impact-value">{{ $stats['questions'] }}</div>
                            <div class="impact-label">questions</div>
                        </div>
                    </div>
                </div>
                
                {{-- About Section --}}
                <div class="prof-section">
                    <h2 class="prof-section-title">About</h2>
                    <div class="stat-card" style="text-align:left;">
                        <p style="font-size:13px;color:#6a737c;line-height:1.6;margin:0;">
                            Your about me section is currently blank. Would you like to add one? 
                            <a href="{{ route('profile.edit') }}" style="color:#0074cc;">Edit profile</a>
                        </p>
                    </div>
                </div>
                
                {{-- Badges Section --}}
                <div class="prof-section">
                    <h2 class="prof-section-title">Badges</h2>
                    <div class="badges-grid" style="grid-template-columns:repeat(3,1fr);gap:16px;">
                        {{-- Badge Or --}}
                        <div class="stat-card">
                            <div style="text-align:center;margin-bottom:12px;">
                                <div style="width:64px;height:64px;margin:0 auto;display:flex;align-items:center;justify-content:center;background:#ffd700;border-radius:50%;font-size:32px;color:#fff;">
                                    ★
                                </div>
                            </div>
                            <h3 style="font-size:15px;color:#232629;margin-bottom:8px;text-align:center;">
                                Vous n'avez pas encore de badge or
                            </h3>
                            <p style="font-size:13px;color:#6a737c;text-align:center;margin-bottom:12px;">
                                Rédigez une réponse qui obtient un score de 100 ou plus pour gagner votre premier badge.
                            </p>
                            <div style="text-align:center;">
                                <a href="{{ route('questions.index') }}" style="display:inline-block;padding:8px 16px;background:#0a95ff;color:#fff;border-radius:3px;font-size:13px;text-decoration:none;">
                                    Parcourir les questions
                                </a>
                            </div>
                        </div>
                        
                        {{-- Badge Argent --}}
                        <div class="stat-card">
                            <div style="text-align:center;margin-bottom:12px;">
                                <div style="width:64px;height:64px;margin:0 auto;display:flex;align-items:center;justify-content:center;background:#c0c0c0;border-radius:50%;font-size:32px;color:#fff;">
                                    ●
                                </div>
                            </div>
                            <h3 style="font-size:15px;color:#232629;margin-bottom:8px;text-align:center;">
                                Vous n'avez pas encore de badge argent
                            </h3>
                            <p style="font-size:13px;color:#6a737c;text-align:center;margin-bottom:12px;">
                                Posez une question qui obtient un score de 25 ou plus pour gagner votre premier badge.
                            </p>
                            <div style="text-align:center;">
                                <a href="{{ route('questions.create') }}" style="display:inline-block;padding:8px 16px;background:#0a95ff;color:#fff;border-radius:3px;font-size:13px;text-decoration:none;">
                                    Poser une question
                                </a>
                            </div>
                        </div>
                        
                        {{-- Badge Bronze --}}
                        <div class="stat-card">
                            <div style="text-align:center;margin-bottom:12px;">
                                <div style="width:64px;height:64px;margin:0 auto;display:flex;align-items:center;justify-content:center;background:#cd7f32;border-radius:50%;font-size:32px;color:#fff;">
                                    {{ $stats['questions'] >= 1 ? '1' : '●' }}
                                </div>
                            </div>
                            <h3 style="font-size:15px;color:#232629;margin-bottom:8px;text-align:center;">
                                {{ $stats['questions'] >= 1 ? '1 badge bronze' : 'Vous n\'avez pas encore de badge bronze' }}
                            </h3>
                            <p style="font-size:13px;color:#6a737c;text-align:center;margin-bottom:12px;">
                                @if($stats['questions'] >= 1)
                                    Félicitations ! Continuez à contribuer pour gagner plus de badges.
                                @else
                                    Posez votre première question pour gagner votre premier badge bronze.
                                @endif
                            </p>
                            <div style="text-align:center;">
                                @if($stats['questions'] >= 1)
                                    <span style="display:inline-block;padding:8px 16px;background:#5eba7d;color:#fff;border-radius:3px;font-size:13px;">
                                        ✓ Informé
                                    </span>
                                @else
                                    <a href="{{ route('questions.create') }}" style="display:inline-block;padding:8px 16px;background:#0a95ff;color:#fff;border-radius:3px;font-size:13px;text-decoration:none;">
                                        Poser une question
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Collectives Section --}}
                <div class="prof-section">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                        <h2 class="prof-section-title" style="margin:0;">Collectives</h2>
                        <a href="#" style="font-size:13px;color:#0074cc;">Edit</a>
                    </div>
                    <div class="empty-state" style="padding:32px;">
                        <div class="empty-icon" style="width:48px;height:48px;">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                            </svg>
                        </div>
                        <p style="font-size:13px;color:#6a737c;margin:0;">
                            Vous n'avez pas encore rejoint de collectives.
                        </p>
                    </div>
                </div>
                
                {{-- Communities Section --}}
                <div class="prof-section">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                        <h2 class="prof-section-title" style="margin:0;">Communities</h2>
                        <a href="#" style="font-size:13px;color:#0074cc;">Edit</a>
                    </div>
                    <div class="stat-card" style="text-align:left;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:32px;height:32px;background:#f48225;border-radius:3px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;flex-shrink:0;">
                                AC
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:13px;color:#0074cc;font-weight:600;margin-bottom:2px;">
                                    AskCampus
                                </div>
                                <div style="font-size:12px;color:#6a737c;">
                                    {{ $stats['reputation'] }} réputation
                                </div>
                            </div>
                            <div style="font-size:12px;color:#6a737c;">
                                1
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Top Tags Section --}}
                <div class="prof-section">
                    <h2 class="prof-section-title">Top tags</h2>
                    @if($stats['tags'] > 0)
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @foreach($userTags->sortByDesc(function($instances) { return $instances->count(); })->take(5) as $tagId => $instances)
                                @php
                                    $tag = $instances->first();
                                    $count = $instances->count();
                                    $tagQuestions = $userQuestions->filter(function($q) use ($tagId) {
                                        return $q->tags->contains('id', $tagId);
                                    });
                                    $totalScore = $tagQuestions->sum(function($q) {
                                        return $q->votes->sum('value');
                                    });
                                @endphp
                                <div class="stat-card" style="padding:12px;">
                                    <div style="display:flex;justify-content:space-between;align-items:center;">
                                        <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" 
                                           style="display:inline-block;padding:4px 8px;background:#e1ecf4;color:#39739d;border-radius:3px;font-size:12px;font-weight:600;">
                                            {{ $tag->name }}
                                        </a>
                                        <div style="display:flex;gap:16px;font-size:12px;color:#6a737c;">
                                            <span>{{ $totalScore }} score</span>
                                            <span>{{ $count }} publication{{ $count > 1 ? 's' : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <p style="font-size:13px;color:#6a737c;margin:0;">
                                Vous n'avez participé à aucun tag.
                            </p>
                        </div>
                    @endif
                </div>
                
            </div>
            
            {{-- Right Sidebar (même que pour Activity) --}}
            <aside class="prof-aside">
                {{-- Reputation Card --}}
                <div class="aside-card rep-card">
                    <div class="rep-value">{{ number_format($stats['reputation']) }}</div>
                    <div class="rep-label">RÉPUTATION</div>
                    <p class="rep-desc">
                        Gagnez de la réputation en 
                        <a href="#" class="rep-link">posant</a>, 
                        <a href="#" class="rep-link">répondant</a> & 
                        <a href="#" class="rep-link">éditant</a>.
                    </p>
                </div>
                
                {{-- Badges Card --}}
                <div class="aside-card">
                    <div class="badges-header">
                        <h3 class="badges-title">Badges</h3>
                    </div>
                    <div class="badges-grid">
                        <div class="badge-item">
                            <div class="badge-icon" style="background:#cd7f32;">●</div>
                            <div class="badge-name">Bronze</div>
                            <div class="badge-progress">{{ $stats['questions'] >= 1 ? '1' : '0' }}</div>
                        </div>
                        <div class="badge-item">
                            <div class="badge-icon" style="background:#c0c0c0;">●</div>
                            <div class="badge-name">Argent</div>
                            <div class="badge-progress">0</div>
                        </div>
                        <div class="badge-item">
                            <div class="badge-icon" style="background:#ffd700;">★</div>
                            <div class="badge-name">Or</div>
                            <div class="badge-progress">0</div>
                        </div>
                    </div>
                </div>
                
                {{-- Stats Card --}}
                <div class="aside-card">
                    <div class="aside-title">Statistiques</div>
                    <div class="aside-stat">
                        <span class="aside-stat-label">Questions</span>
                        <span class="aside-stat-value">{{ $stats['questions'] }}</span>
                    </div>
                    <div class="aside-stat">
                        <span class="aside-stat-label">Réponses</span>
                        <span class="aside-stat-value">{{ $stats['answers'] }}</span>
                    </div>
                    <div class="aside-stat">
                        <span class="aside-stat-label">Acceptées</span>
                        <span class="aside-stat-value" style="color:#5eba7d;">{{ $stats['accepted'] }}</span>
                    </div>
                    <div class="aside-stat" style="border-top:1px solid #e3e6e8;margin-top:8px;padding-top:8px;">
                        <span class="aside-stat-label">Personnes atteintes</span>
                        <span class="aside-stat-value">~{{ number_format($stats['reached']) }}</span>
                    </div>
                </div>
            </aside>
        </div>
        
        {{-- ═══ ONGLET ACTIVITÉ ═══ --}}
        <div class="prof-tab-content" data-tab-content="activity" style="display:none;">
        
        {{-- LEFT SIDEBAR --}}
        <aside class="prof-sidebar">
            <div class="prof-sidebar-title">Résumé</div>
            <ul class="prof-menu">
                <li class="prof-menu-item active" data-section="summary">Résumé</li>
                <li class="prof-menu-item" data-section="answers">Réponses</li>
                <li class="prof-menu-item" data-section="questions">Questions</li>
                <li class="prof-menu-item" data-section="tags">Tags</li>
                <li class="prof-menu-item" data-section="badges">Badges</li>
                <li class="prof-menu-item" data-section="reputation">Réputation</li>
                <li class="prof-menu-item" data-section="votes">Votes</li>
            </ul>
        </aside>
        
        {{-- MAIN CONTENT --}}
        <main class="prof-main">
            
            {{-- SECTION: SUMMARY --}}
            <div class="prof-content-section" data-content="summary">
                <h2 class="prof-section-title">Résumé</h2>
                
                {{-- Impact Stats --}}
                <div class="impact-grid">
                    <div class="impact-card">
                        <div class="impact-value">{{ number_format($stats['reached']) }}</div>
                        <div class="impact-label">personnes atteintes</div>
                    </div>
                    <div class="impact-card">
                        <div class="impact-value">{{ $stats['questions'] + $stats['answers'] }}</div>
                        <div class="impact-label">publications</div>
                    </div>
                </div>
                
                {{-- Info Cards --}}
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                        </div>
                        <h3 class="stat-title">La réputation, c'est comment la communauté vous remercie</h3>
                        <p class="stat-desc">
                            Lorsque les utilisateurs votent pour vos publications utiles, vous gagnez de la réputation et débloquez de nouveaux privilèges.
                        </p>
                        <a href="#" class="stat-link">En savoir plus sur la réputation</a>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                            </svg>
                        </div>
                        <h3 class="stat-title">Mesurez votre impact</h3>
                        <p class="stat-desc">
                            Vos publications et votre aide aident ici des centaines ou des milliers de personnes à la recherche d'aide.
                        </p>
                    </div>
                </div>
            </div>

            
            {{-- SECTION: ANSWERS --}}
            <div class="prof-content-section" data-content="answers" style="display:none;">
                <h2 class="prof-section-title">{{ $stats['answers'] }} Réponse{{ $stats['answers'] > 1 ? 's' : '' }}</h2>
                
                @if($stats['answers'] > 0)
                    <div class="activity-list">
                        @foreach($userAnswers->sortByDesc('created_at')->take(20) as $answer)
                            @php
                                $voteScore = $answer->votes->sum('value');
                            @endphp
                            <div class="activity-item">
                                <div class="activity-header">
                                    <span class="activity-type">Réponse</span>
                                    <span class="activity-date">{{ $answer->created_at->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('questions.show', $answer->question) }}#answer-{{ $answer->id }}" class="activity-title">
                                    {{ $answer->question->title ?? 'Question supprimée' }}
                                </a>
                                <div class="activity-stats">
                                    <span class="activity-stat">
                                        <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M1 12h16L9 4z"/>
                                        </svg>
                                        {{ $voteScore }} vote{{ abs($voteScore) > 1 ? 's' : '' }}
                                    </span>
                                    @if($answer->is_accepted)
                                        <span class="activity-stat" style="color:#5eba7d;font-weight:700;">
                                            <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M16 4.41L14.59 3 6 11.59 2.41 8 1 9.41l5 5z"/>
                                            </svg>
                                            Acceptée
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-4 6V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10c.55 0 1-.45 1-1z"/>
                            </svg>
                        </div>
                        <h3 class="empty-title">Aucune réponse pour le moment</h3>
                        <p class="empty-desc">Vous n'avez pas encore répondu à des questions.<br>Parcourez les questions et partagez vos connaissances !</p>
                    </div>
                @endif
            </div>
            
            {{-- SECTION: QUESTIONS --}}
            <div class="prof-content-section" data-content="questions" style="display:none;">
                <h2 class="prof-section-title">{{ $stats['questions'] }} Question{{ $stats['questions'] > 1 ? 's' : '' }}</h2>
                
                @if($stats['questions'] > 0)
                    <div class="activity-list">
                        @foreach($userQuestions->sortByDesc('created_at') as $question)
                            @php
                                $voteScore = $question->votes->sum('value');
                            @endphp
                            <div class="activity-item">
                                <div class="activity-header">
                                    <span class="activity-type">Question</span>
                                    <span class="activity-date">{{ $question->created_at->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('questions.show', $question) }}" class="activity-title">
                                    {{ $question->title }}
                                </a>
                                <div class="activity-stats">
                                    <span class="activity-stat">
                                        <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M1 12h16L9 4z"/>
                                        </svg>
                                        {{ $voteScore }} vote{{ abs($voteScore) > 1 ? 's' : '' }}
                                    </span>
                                    <span class="activity-stat">
                                        <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-4 6V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10c.55 0 1-.45 1-1z"/>
                                        </svg>
                                        {{ $question->answers_count }} réponse{{ $question->answers_count > 1 ? 's' : '' }}
                                    </span>
                                    <span class="activity-stat">
                                        <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0z"/>
                                        </svg>
                                        {{ number_format($question->views) }} vue{{ $question->views > 1 ? 's' : '' }}
                                    </span>
                                    @if($question->is_solved)
                                        <span class="activity-stat" style="color:#5eba7d;font-weight:700;">
                                            ✓ Résolue
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                        </div>
                        <h3 class="empty-title">Aucune question pour le moment</h3>
                        <p class="empty-desc">Vous n'avez pas encore posé de questions.<br>Posez votre première question et obtenez de l'aide !</p>
                    </div>
                @endif
            </div>
            
            {{-- SECTION: TAGS --}}
            <div class="prof-content-section" data-content="tags" style="display:none;">
                <h2 class="prof-section-title">{{ $stats['tags'] }} Tag{{ $stats['tags'] > 1 ? 's' : '' }}</h2>
                
                @if($stats['tags'] > 0)
                    <div class="tags-grid">
                        @foreach($userTags as $tagId => $tagInstances)
                            @php
                                $tag = $tagInstances->first();
                                $count = $tagInstances->count();
                                $tagQuestions = $userQuestions->filter(function($q) use ($tagId) {
                                    return $q->tags->contains('id', $tagId);
                                });
                                $totalScore = $tagQuestions->sum(function($q) {
                                    return $q->votes->sum('value');
                                });
                            @endphp
                            <div class="tag-card">
                                <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="tag-card-name">
                                    {{ $tag->name }}
                                </a>
                                <div class="tag-card-stats">
                                    <span>{{ $count }} question{{ $count > 1 ? 's' : '' }}</span>
                                    <span>{{ $totalScore }} score</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
                            </svg>
                        </div>
                        <h3 class="empty-title">Aucun tag pour le moment</h3>
                        <p class="empty-desc">Vous n'avez pas encore utilisé de tags.<br>Ajoutez des tags à vos questions pour les catégoriser !</p>
                    </div>
                @endif
            </div>
            
            {{-- SECTION: BADGES --}}
            <div class="prof-content-section" data-content="badges" style="display:none;">
                <h2 class="prof-section-title">Badges</h2>
                
                <div class="badges-grid" style="grid-template-columns:repeat(4,1fr);gap:12px;">
                    {{-- Badge Bronze: Première question --}}
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#cd7f32;">●</div>
                        <div class="badge-name">Curieux</div>
                        <div class="badge-progress">{{ $stats['questions'] >= 1 ? '1/1 ✓' : '0/1' }}</div>
                    </div>
                    
                    {{-- Badge Bronze: Première réponse --}}
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#cd7f32;">●</div>
                        <div class="badge-name">Serviable</div>
                        <div class="badge-progress">{{ $stats['answers'] >= 1 ? '1/1 ✓' : '0/1' }}</div>
                    </div>
                    
                    {{-- Badge Argent: 10 questions --}}
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#c0c0c0;">●</div>
                        <div class="badge-name">Inquisiteur</div>
                        <div class="badge-progress">{{ min($stats['questions'], 10) }}/10</div>
                    </div>
                    
                    {{-- Badge Argent: 10 réponses acceptées --}}
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#c0c0c0;">●</div>
                        <div class="badge-name">Expert</div>
                        <div class="badge-progress">{{ min($stats['accepted'], 10) }}/10</div>
                    </div>
                    
                    {{-- Badge Or: 100 réputation --}}
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#ffd700;">★</div>
                        <div class="badge-name">Notable</div>
                        <div class="badge-progress">{{ min($stats['reputation'], 100) }}/100</div>
                    </div>
                    
                    {{-- Badge Or: 50 questions --}}
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#ffd700;">★</div>
                        <div class="badge-name">Socrate</div>
                        <div class="badge-progress">{{ min($stats['questions'], 50) }}/50</div>
                    </div>
                    
                    {{-- Badge Spécial: Autobiographe --}}
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#f48225;">✎</div>
                        <div class="badge-name">Autobiographe</div>
                        <div class="badge-progress">0/1</div>
                    </div>
                    
                    {{-- Badge Spécial: Informé --}}
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#0074cc;">ⓘ</div>
                        <div class="badge-name">Informé</div>
                        <div class="badge-progress">0/1</div>
                    </div>
                </div>
            </div>
            
            {{-- SECTION: REPUTATION --}}
            <div class="prof-content-section" data-content="reputation" style="display:none;">
                <h2 class="prof-section-title">Réputation</h2>
                
                <div class="impact-grid">
                    <div class="impact-card">
                        <div class="impact-value">{{ number_format($stats['reputation']) }}</div>
                        <div class="impact-label">réputation totale</div>
                    </div>
                    <div class="impact-card">
                        <div class="impact-value">+{{ number_format($stats['reputation'] - 1) }}</div>
                        <div class="impact-label">ce mois-ci</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <h3 class="stat-title">Comment gagner de la réputation</h3>
                    <div style="text-align:left;font-size:13px;color:#6a737c;line-height:1.8;">
                        <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #e3e6e8;">
                            <span>Votre question est votée positivement</span>
                            <strong style="color:#5eba7d;">+5</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #e3e6e8;">
                            <span>Votre réponse est votée positivement</span>
                            <strong style="color:#5eba7d;">+10</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #e3e6e8;">
                            <span>Votre réponse est acceptée</span>
                            <strong style="color:#5eba7d;">+15</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #e3e6e8;">
                            <span>Votre question est votée négativement</span>
                            <strong style="color:#d93025;">-2</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding:6px 0;">
                            <span>Votre réponse est votée négativement</span>
                            <strong style="color:#d93025;">-2</strong>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- SECTION: VOTES --}}
            <div class="prof-content-section" data-content="votes" style="display:none;">
                <h2 class="prof-section-title">Votes</h2>
                
                <div class="impact-grid">
                    <div class="impact-card">
                        <div class="impact-value" style="color:#5eba7d;">{{ $upvotes }}</div>
                        <div class="impact-label">votes positifs</div>
                    </div>
                    <div class="impact-card">
                        <div class="impact-value" style="color:#d93025;">{{ $downvotes }}</div>
                        <div class="impact-label">votes négatifs</div>
                    </div>
                </div>
                
                @if($userVotes->count() > 0)
                    <div class="votes-list">
                        @foreach($userVotes as $vote)
                            @php
                                $votable = $vote->votable;
                                if (!$votable) continue;
                                
                                $isQuestion = $vote->votable_type === 'App\Models\Question';
                                $title = $isQuestion ? $votable->title : ($votable->question->title ?? 'Question supprimée');
                                $url = $isQuestion 
                                    ? route('questions.show', $votable) 
                                    : route('questions.show', $votable->question) . '#answer-' . $votable->id;
                            @endphp
                            <div class="vote-item">
                                <div class="vote-badge {{ $vote->value > 0 ? 'up' : 'down' }}">
                                    {{ $vote->value > 0 ? '▲' : '▼' }}
                                </div>
                                <div class="vote-content">
                                    <a href="{{ $url }}" class="vote-title">{{ $title }}</a>
                                    <div class="vote-date">{{ $vote->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                            </svg>
                        </div>
                        <h3 class="empty-title">Aucun vote pour le moment</h3>
                        <p class="empty-desc">Vous n'avez pas encore voté sur des publications.<br>Votez pour les bonnes questions et réponses !</p>
                    </div>
                @endif
            </div>
            
        </main>

        
        {{-- RIGHT SIDEBAR --}}
        <aside class="prof-aside">
            
            {{-- Reputation Card --}}
            <div class="aside-card rep-card">
                <div class="rep-value">{{ number_format($stats['reputation']) }}</div>
                <div class="rep-label">RÉPUTATION</div>
                <p class="rep-desc">
                    Gagnez de la réputation en 
                    <a href="#" class="rep-link">posant</a>, 
                    <a href="#" class="rep-link">répondant</a> & 
                    <a href="#" class="rep-link">éditant</a>.
                </p>
            </div>
            
            {{-- Badges Card --}}
            <div class="aside-card">
                <div class="badges-header">
                    <h3 class="badges-title">Badges</h3>
                    <a href="#" style="font-size:13px;color:#0074cc;" onclick="showSection('badges'); return false;">Voir tous</a>
                </div>
                <div class="badges-grid">
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#cd7f32;">●</div>
                        <div class="badge-name">Bronze</div>
                        <div class="badge-progress">{{ $stats['questions'] >= 1 ? '1' : '0' }}</div>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#c0c0c0;">●</div>
                        <div class="badge-name">Argent</div>
                        <div class="badge-progress">0</div>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon" style="background:#ffd700;">★</div>
                        <div class="badge-name">Or</div>
                        <div class="badge-progress">0</div>
                    </div>
                </div>
            </div>
            
            {{-- Stats Card --}}
            <div class="aside-card">
                <div class="aside-title">Statistiques</div>
                <div class="aside-stat">
                    <span class="aside-stat-label">Questions</span>
                    <span class="aside-stat-value">{{ $stats['questions'] }}</span>
                </div>
                <div class="aside-stat">
                    <span class="aside-stat-label">Réponses</span>
                    <span class="aside-stat-value">{{ $stats['answers'] }}</span>
                </div>
                <div class="aside-stat">
                    <span class="aside-stat-label">Acceptées</span>
                    <span class="aside-stat-value" style="color:#5eba7d;">{{ $stats['accepted'] }}</span>
                </div>
                <div class="aside-stat" style="border-top:1px solid #e3e6e8;margin-top:8px;padding-top:8px;">
                    <span class="aside-stat-label">Personnes atteintes</span>
                    <span class="aside-stat-value">~{{ number_format($stats['reached']) }}</span>
                </div>
            </div>
            
            {{-- Top Tags --}}
            @if($stats['tags'] > 0)
                <div class="aside-card">
                    <div class="aside-title">Tags populaires</div>
                    @foreach($userTags->sortByDesc(function($instances) { return $instances->count(); })->take(5) as $tagId => $instances)
                        @php
                            $tag = $instances->first();
                            $count = $instances->count();
                        @endphp
                        <div class="aside-stat">
                            <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" 
                               style="color:#39739d;background:#e1ecf4;padding:2px 6px;border-radius:3px;font-size:12px;">
                                {{ $tag->name }}
                            </a>
                            <span class="aside-stat-value">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
            
        </aside>
        
        </div>{{-- Fin onglet Activity --}}
        
    </div>{{-- Fin prof-grid --}}
    
</div>{{-- Fin prof-wrap --}}

{{-- ═══ JAVASCRIPT ═══ --}}
<script>
// Gestion des onglets principaux
document.querySelectorAll('.prof-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        const tabName = this.dataset.tab;
        
        // Retirer active de tous les onglets
        document.querySelectorAll('.prof-tab').forEach(t => t.classList.remove('active'));
        // Ajouter active à l'onglet cliqué
        this.classList.add('active');
        
        // Cacher tous les contenus d'onglets
        document.querySelectorAll('.prof-tab-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // Afficher le contenu de l'onglet sélectionné
        const targetContent = document.querySelector(`.prof-tab-content[data-tab-content="${tabName}"]`);
        if (targetContent) {
            targetContent.style.display = 'contents'; // Utiliser 'contents' pour garder la grille
        }
    });
});

// Gestion du menu latéral (sections)
document.querySelectorAll('.prof-menu-item').forEach(item => {
    item.addEventListener('click', function() {
        const section = this.dataset.section;
        showSection(section);
    });
});

function showSection(sectionName) {
    // Retirer active de tous les items du menu
    document.querySelectorAll('.prof-menu-item').forEach(i => i.classList.remove('active'));
    // Ajouter active à l'item cliqué
    const menuItem = document.querySelector(`.prof-menu-item[data-section="${sectionName}"]`);
    if (menuItem) {
        menuItem.classList.add('active');
    }
    
    // Cacher toutes les sections
    document.querySelectorAll('.prof-content-section').forEach(s => s.style.display = 'none');
    // Afficher la section demandée
    const section = document.querySelector(`.prof-content-section[data-content="${sectionName}"]`);
    if (section) {
        section.style.display = 'block';
        // Scroll vers le haut
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// Animation au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter une animation fade-in aux cartes
    const cards = document.querySelectorAll('.stat-card, .activity-item, .tag-card, .badge-item');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';
        setTimeout(() => {
            card.style.transition = 'all 0.3s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 30);
    });
});
</script>

</x-app-layout>
