<x-app-layout>
@php $user = auth()->user(); @endphp

<style>
    /* ── Shared card ─── */
    .db-card {
        background:#fff;border:1px solid #e5e7eb;border-radius:12px;
        overflow:hidden;margin-bottom:20px;
    }
    .db-card-head {
        display:flex;align-items:center;justify-content:space-between;
        padding:13px 18px;background:#f9fafb;border-bottom:1px solid #e5e7eb;
        font-size:13px;font-weight:700;color:#374151;
    }
    .db-card-head .head-icon { display:flex;align-items:center;gap:7px; }
    .db-card-head svg { width:16px;height:16px; }
    .db-card-body { padding:18px; }

    /* ── Stat tiles ─── */
    .stat-grid { display:grid;gap:14px; }
    .stat-tile {
        background:#fff;border:1px solid #e5e7eb;border-radius:10px;
        padding:16px;display:flex;flex-direction:column;gap:6px;
        position:relative;overflow:hidden;transition:box-shadow .15s;
    }
    .stat-tile:hover { box-shadow:0 4px 14px rgba(0,0,0,.09); }
    .stat-tile .tile-accent {
        position:absolute;left:0;top:0;bottom:0;width:4px;border-radius:10px 0 0 10px;
    }
    .stat-tile .tile-icon {
        width:36px;height:36px;border-radius:9px;
        display:flex;align-items:center;justify-content:center;
        margin-bottom:4px;
    }
    .stat-tile .tile-icon svg { width:18px;height:18px; }
    .stat-tile .tile-val { font-size:26px;font-weight:800;color:#111827;line-height:1; }
    .stat-tile .tile-label { font-size:12px;color:#9ca3af;font-weight:500; }

    /* ── Table ─── */
    .mod-table { width:100%;border-collapse:collapse;font-size:13px; }
    .mod-table th {
        padding:10px 14px;text-align:left;font-size:11px;font-weight:700;
        text-transform:uppercase;letter-spacing:.04em;
        color:#9ca3af;background:#f9fafb;border-bottom:1px solid #e5e7eb;
    }
    .mod-table td {
        padding:11px 14px;border-bottom:1px solid #f3f4f6;
        vertical-align:middle;color:#374151;
    }
    .mod-table tr:last-child td { border-bottom:none; }
    .mod-table tr:hover td { background:#fafafa; }

    /* action buttons */
    .btn-act {
        display:inline-flex;align-items:center;gap:4px;
        padding:4px 10px;font-size:12px;font-weight:600;
        border-radius:6px;border:none;cursor:pointer;line-height:1.4;
        transition:opacity .15s;text-decoration:none;
    }
    .btn-act:hover { opacity:.82; }
    .btn-danger  { background:#fef2f2;color:#dc2626; }
    .btn-warn    { background:#fff7ed;color:#92400e; }
    .btn-success { background:#f0fdf4;color:#16a34a; }
    .btn-primary { background:#eef2ff;color:#4f46e5; }

    /* Badge helpers */
    .badge {
        display:inline-flex;align-items:center;padding:3px 8px;
        border-radius:20px;font-size:11px;font-weight:600;
    }
    .badge-open   { background:#dcfce7;color:#16a34a; }
    .badge-closed { background:#fee2e2;color:#dc2626; }
    .badge-solved { background:#dbeafe;color:#1d4ed8; }
    .badge-mod    { background:#fef3c7;color:#92400e; }

    /* Progress bar */
    .prog-bar { height:6px;background:#e5e7eb;border-radius:99px;overflow:hidden; }
    .prog-fill { height:100%;border-radius:99px;
                 background:linear-gradient(90deg,#5046e5,#7c3aed);
                 transition:width .4s ease; }

    /* Avatar */
    .u-avatar {
        width:40px;height:40px;border-radius:10px;
        display:flex;align-items:center;justify-content:center;
        font-weight:800;font-size:16px;color:#fff;flex-shrink:0;
    }

    /* Rep card */
    .rep-hero {
        background:linear-gradient(135deg,#5046e5 0%,#7c3aed 100%);
        border-radius:12px;padding:22px 22px 18px;
        color:#fff;margin-bottom:20px;
        position:relative;overflow:hidden;
    }
    .rep-hero::after {
        content:'';position:absolute;right:-30px;top:-30px;
        width:140px;height:140px;border-radius:50%;
        background:rgba(255,255,255,.08);
    }
</style>

@if($user->isModerator())
{{-- ══════════════════════════════════════════
     MODERATOR DASHBOARD
══════════════════════════════════════════ --}}

@php
    $palette = ['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2'];
    $modColor = $palette[abs(crc32($user->name)) % count($palette)];
@endphp

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
    <div style="display:flex;align-items:center;gap:14px;">
        <div class="u-avatar" style="background:{{ $modColor }};width:52px;height:52px;font-size:20px;border-radius:13px;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:2px;">
                <h1 style="font-size:22px;font-weight:800;color:#111827;margin:0;">Tableau de bord modérateur</h1>
                <span class="badge badge-mod">⚡ MOD</span>
            </div>
            <p style="font-size:13px;color:#9ca3af;margin:0;">Bienvenue, {{ $user->name }} — gérez le contenu de la communauté</p>
        </div>
    </div>
    <a href="{{ route('questions.create') }}"
       style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;
              font-size:13px;font-weight:600;color:#fff;border-radius:9px;
              background:linear-gradient(135deg,#5046e5,#7c3aed);
              box-shadow:0 3px 10px rgba(80,70,229,.3);text-decoration:none;"
       onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
        <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Poser une question
    </a>
</div>

{{-- Stats row --}}
<div class="stat-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:22px;">
    <div class="stat-tile">
        <div class="tile-accent" style="background:#5046e5;"></div>
        <div class="tile-icon" style="background:#eef2ff;">
            <svg fill="none" stroke="#5046e5" viewBox="0 0 24 24" style="width:18px;height:18px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="tile-val">{{ $modStats['totalQuestions'] }}</div>
        <div class="tile-label">Questions totales</div>
        <div style="font-size:11px;color:#9ca3af;margin-top:2px;">
            <span style="color:#16a34a;font-weight:600;">{{ $modStats['openQuestions'] }}</span> ouvertes &nbsp;·&nbsp;
            <span style="color:#dc2626;font-weight:600;">{{ $modStats['closedQuestions'] }}</span> fermées
        </div>
    </div>
    <div class="stat-tile">
        <div class="tile-accent" style="background:#059669;"></div>
        <div class="tile-icon" style="background:#f0fdf4;">
            <svg fill="none" stroke="#059669" viewBox="0 0 24 24" style="width:18px;height:18px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
        </div>
        <div class="tile-val">{{ $modStats['totalAnswers'] }}</div>
        <div class="tile-label">Réponses données</div>
    </div>
    <div class="stat-tile">
        <div class="tile-accent" style="background:#0891b2;"></div>
        <div class="tile-icon" style="background:#ecfeff;">
            <svg fill="none" stroke="#0891b2" viewBox="0 0 24 24" style="width:18px;height:18px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="tile-val">{{ $modStats['totalUsers'] }}</div>
        <div class="tile-label">Utilisateurs inscrits</div>
        <div style="font-size:11px;color:#9ca3af;margin-top:2px;">
            <span style="color:#0891b2;font-weight:600;">{{ $modStats['totalTags'] }}</span> tags actifs
        </div>
    </div>
</div>

{{-- Questions to moderate --}}
<div class="db-card">
    <div class="db-card-head">
        <div class="head-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Questions récentes
        </div>
        <a href="{{ route('questions.index') }}" style="font-size:12px;color:#5046e5;font-weight:500;">Voir toutes →</a>
    </div>
    <div style="overflow-x:auto;">
        <table class="mod-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Tags</th>
                    <th style="text-align:center;">Rép.</th>
                    <th style="text-align:center;">Vues</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentQuestions as $q)
                <tr>
                    <td style="max-width:260px;">
                        <a href="{{ route('questions.show', $q) }}"
                           style="color:#1d4ed8;font-weight:500;line-height:1.3;
                                  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"
                           onmouseover="this.style.color='#1e40af'" onmouseout="this.style.color='#1d4ed8'">
                            {{ $q->title }}
                        </a>
                    </td>
                    <td style="white-space:nowrap;">
                        <div style="display:flex;align-items:center;gap:6px;">
                            @php
                                $ac=['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2'];
                                $ci=abs(crc32($q->user->name??''))%count($ac);
                            @endphp
                            <div style="width:22px;height:22px;border-radius:6px;background:{{ $ac[$ci] }};
                                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span style="color:#fff;font-size:10px;font-weight:700;">
                                    {{ strtoupper(substr($q->user->name??'?',0,1)) }}
                                </span>
                            </div>
                            <span style="font-size:12px;color:#374151;">{{ $q->user->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:3px;max-width:120px;">
                            @foreach($q->tags->take(2) as $tag)
                                <span style="display:inline-flex;align-items:center;padding:2px 6px;
                                             font-size:11px;color:#5046e5;background:#eef2ff;border-radius:5px;">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td style="text-align:center;font-weight:700;color:#374151;">
                        {{ $q->answers->count() }}
                    </td>
                    <td style="text-align:center;font-size:12px;color:#9ca3af;">
                        {{ $q->views >= 1000 ? round($q->views/1000,1).'k' : $q->views }}
                    </td>
                    <td>
                        @if($q->is_closed)
                            <span class="badge badge-closed">Fermée</span>
                        @elseif($q->is_solved)
                            <span class="badge badge-solved">Résolue</span>
                        @else
                            <span class="badge badge-open">Ouverte</span>
                        @endif
                    </td>
                    <td style="white-space:nowrap;">
                        <div style="display:flex;gap:4px;">
                            @if($q->is_closed)
                                <form method="POST" action="{{ route('questions.reopen', $q) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-act btn-success">
                                        <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                        </svg>
                                        Rouvrir
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('questions.close', $q) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-act btn-warn">
                                        <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zM10 11V7a2 2 0 114 0v4"/>
                                        </svg>
                                        Fermer
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('questions.destroy', $q) }}" style="display:inline;"
                                  onsubmit="return confirm('Supprimer cette question et toutes ses réponses ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-act btn-danger">
                                    <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Answers --}}
<div class="db-card">
    <div class="db-card-head">
        <div class="head-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            Réponses récentes
        </div>
    </div>
    <div style="overflow-x:auto;">
        <table class="mod-table">
            <thead>
                <tr>
                    <th>Contenu</th>
                    <th>Auteur</th>
                    <th>Question liée</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentAnswers as $ans)
                <tr>
                    <td style="max-width:220px;">
                        <p style="margin:0;font-size:12px;color:#6b7280;
                                  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ Str::limit(strip_tags($ans->body), 120) }}
                        </p>
                        @if($ans->is_accepted)
                            <span class="badge badge-solved" style="margin-top:4px;">✓ Acceptée</span>
                        @endif
                    </td>
                    <td style="white-space:nowrap;font-size:12px;color:#374151;">
                        {{ $ans->user->name ?? '—' }}
                    </td>
                    <td style="max-width:180px;">
                        <a href="{{ route('questions.show', $ans->question) }}"
                           style="color:#1d4ed8;font-size:12px;
                                  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"
                           onmouseover="this.style.color='#1e40af'" onmouseout="this.style.color='#1d4ed8'">
                            {{ $ans->question->title ?? '—' }}
                        </a>
                    </td>
                    <td style="font-size:12px;color:#9ca3af;white-space:nowrap;">
                        {{ $ans->created_at->diffForHumans() }}
                    </td>
                    <td>
                        <form method="POST" action="{{ route('answers.destroy', $ans) }}" style="display:inline;"
                              onsubmit="return confirm('Supprimer cette réponse ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-act btn-danger">
                                <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Users --}}
<div class="db-card">
    <div class="db-card-head">
        <div class="head-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Utilisateurs récents
        </div>
    </div>
    <div style="padding:6px 0;">
        @foreach($recentUsers as $u)
            @php
                $uc=['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2'];
                $uci=abs(crc32($u->name))%count($uc);
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;
                        padding:10px 18px;border-bottom:1px solid #f3f4f6;"
                 onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:9px;background:{{ $uc[$uci] }};
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="color:#fff;font-weight:700;font-size:13px;">
                            {{ strtoupper(substr($u->name,0,1)) }}
                        </span>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#111827;">{{ $u->name }}</div>
                        <div style="font-size:11px;color:#9ca3af;">{{ $u->email }}</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;">
                    @if($u->is_moderator)
                        <span class="badge badge-mod">Modérateur</span>
                    @endif
                    <span style="font-size:12px;font-weight:700;color:#5046e5;">
                        {{ number_format($u->reputation ?? 0) }} pts
                    </span>
                    <span style="font-size:12px;color:#9ca3af;">
                        {{ $u->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>

@else
{{-- ══════════════════════════════════════════
     STUDENT DASHBOARD
══════════════════════════════════════════ --}}
@php
    $currentRep   = $user->reputation ?? 0;
    $nextLevel    = ceil(($currentRep + 1) / 100) * 100;
    $prevLevel    = floor($currentRep / 100) * 100;
    $progress     = $nextLevel > $prevLevel ? (($currentRep - $prevLevel) / ($nextLevel - $prevLevel)) * 100 : 0;
    $qCount       = $user->questions->count();
    $aCount       = $user->answers->count();
    $accCount     = $user->answers->where('is_accepted', true)->count();
    $acceptRate   = $aCount > 0 ? round(($accCount / $aCount) * 100) : 0;
    $palette      = ['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2'];
    $avatarColor  = $palette[abs(crc32($user->name)) % count($palette)];
@endphp

{{-- Hero Reputation Card --}}
<div class="rep-hero">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px;">
        <div class="u-avatar" style="background:rgba(255,255,255,.2);backdrop-filter:blur(4px);
                                      border:2px solid rgba(255,255,255,.3);
                                      width:56px;height:56px;border-radius:14px;font-size:22px;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h1 style="font-size:20px;font-weight:800;margin:0;color:#fff;">
                Bienvenue, {{ $user->name }} 👋
            </h1>
            <p style="font-size:12px;color:rgba(255,255,255,.7);margin:3px 0 0;">
                Voici un aperçu de votre activité sur AskCampus
            </p>
        </div>
    </div>

    <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:10px;">
        <span style="font-size:42px;font-weight:900;color:#fff;line-height:1;">{{ number_format($currentRep) }}</span>
        <span style="font-size:16px;color:rgba(255,255,255,.7);">points de réputation</span>
    </div>

    <div>
        <div style="display:flex;justify-content:space-between;font-size:12px;
                    color:rgba(255,255,255,.7);margin-bottom:6px;">
            <span>Niveau {{ floor($currentRep / 100) }}</span>
            <span>Prochain : {{ $nextLevel }} pts</span>
        </div>
        <div style="height:6px;background:rgba(255,255,255,.2);border-radius:99px;overflow:hidden;">
            <div style="height:100%;width:{{ $progress }}%;background:#fff;border-radius:99px;"></div>
        </div>
        <p style="font-size:12px;color:rgba(255,255,255,.65);margin:6px 0 0;">
            Plus que <strong style="color:#fff;">{{ $nextLevel - $currentRep }}</strong> points pour le niveau suivant
        </p>
    </div>
</div>

{{-- Stats cards --}}
<div class="stat-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:22px;">
    <div class="stat-tile">
        <div class="tile-accent" style="background:#5046e5;"></div>
        <div class="tile-icon" style="background:#eef2ff;">
            <svg fill="none" stroke="#5046e5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="tile-val">{{ $qCount }}</div>
        <div class="tile-label">Questions posées</div>
        <div style="margin-top:8px;padding-top:8px;border-top:1px solid #f3f4f6;">
            <a href="{{ route('questions.index') }}"
               style="font-size:12px;color:#5046e5;font-weight:600;"
               onmouseover="this.style.color='#4338ca'" onmouseout="this.style.color='#5046e5'">
                Voir mes questions →
            </a>
        </div>
    </div>

    <div class="stat-tile">
        <div class="tile-accent" style="background:#059669;"></div>
        <div class="tile-icon" style="background:#f0fdf4;">
            <svg fill="none" stroke="#059669" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
        </div>
        <div class="tile-val">{{ $aCount }}</div>
        <div class="tile-label">Réponses données</div>
        <div style="margin-top:8px;padding-top:8px;border-top:1px solid #f3f4f6;">
            <span style="font-size:12px;color:#9ca3af;">Taux d'acceptation :
                <strong style="color:#059669;">{{ $acceptRate }}%</strong>
            </span>
        </div>
    </div>

    <div class="stat-tile">
        <div class="tile-accent" style="background:#d97706;"></div>
        <div class="tile-icon" style="background:#fffbeb;">
            <svg fill="none" stroke="#d97706" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
        </div>
        <div class="tile-val">{{ $accCount }}</div>
        <div class="tile-label">Réponses acceptées</div>
        <div style="margin-top:8px;padding-top:8px;border-top:1px solid #f3f4f6;">
            <span style="font-size:12px;color:#d97706;font-weight:600;">
                +{{ $accCount * 20 }} pts gagnés
            </span>
        </div>
    </div>
</div>

{{-- Recent Activity --}}
<div class="db-card">
    <div class="db-card-head">
        <div class="head-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Activité récente
        </div>
        <a href="{{ route('questions.create') }}"
           style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;
                  font-size:12px;font-weight:600;color:#5046e5;background:#eef2ff;
                  border-radius:7px;text-decoration:none;"
           onmouseover="this.style.background='#e0e7ff'" onmouseout="this.style.background='#eef2ff'">
            + Nouvelle question
        </a>
    </div>
    <div class="db-card-body" style="padding:0;">
        @forelse($user->questions()->latest()->take(5)->get() as $question)
            <div style="padding:14px 18px;border-bottom:1px solid #f3f4f6;display:flex;align-items:flex-start;gap:12px;"
                 onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                <div style="width:30px;height:30px;border-radius:8px;background:#eef2ff;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                    <svg style="width:14px;height:14px;color:#5046e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <a href="{{ route('questions.show', $question) }}"
                       style="font-size:14px;font-weight:600;color:#1d4ed8;display:block;line-height:1.4;"
                       onmouseover="this.style.color='#1e40af'" onmouseout="this.style.color='#1d4ed8'">
                        {{ $question->title }}
                    </a>
                    <div style="display:flex;align-items:center;gap:12px;margin-top:5px;font-size:12px;color:#9ca3af;">
                        <span>{{ $question->answers->count() }} réponse{{ $question->answers->count() > 1 ? 's' : '' }}</span>
                        <span>{{ $question->views }} vues</span>
                        <span>{{ $question->created_at->diffForHumans() }}</span>
                        @if($question->is_solved)
                            <span class="badge badge-solved" style="font-size:10px;">✓ Résolue</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align:center;padding:40px 20px;">
                <svg style="width:48px;height:48px;color:#d1d5db;margin:0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p style="font-size:14px;color:#6b7280;margin:12px 0 16px;">Aucune activité pour l'instant</p>
                <a href="{{ route('questions.create') }}"
                   style="display:inline-flex;padding:9px 16px;font-size:13px;font-weight:600;
                          color:#fff;background:linear-gradient(135deg,#5046e5,#7c3aed);
                          border-radius:8px;text-decoration:none;box-shadow:0 2px 8px rgba(80,70,229,.3);">
                    Poser votre première question
                </a>
            </div>
        @endforelse
    </div>
</div>

@endif
</x-app-layout>
