<x-app-layout>

<style>
/* SO Modern Layout Styles */
.so-profile-container {
    max-width: 1100px;
    margin: 0 auto;
    color: #232629;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    padding-bottom: 64px;
}

/* Header Area */
.profile-header { display: flex; gap: 20px; align-items: flex-start; margin-bottom: 24px; }
.profile-avatar { width: 128px; height: 128px; border-radius: 5px; flex-shrink: 0; display:flex; align-items:center; justify-content:center; font-size:48px; font-weight:bold; color:#fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.profile-info { flex: 1; }
.profile-name { font-size: 34px; line-height: 1.2; margin: 0 0 8px; color: #232629; font-weight: normal; }
.profile-meta { display: flex; gap: 16px; color: #6a737c; font-size: 13px; align-items: center; flex-wrap: wrap; margin-bottom: 12px; }
.profile-meta-item { display: flex; align-items: center; gap: 4px; }

/* Tabs */
.profile-tabs { display: flex; gap: 4px; border-bottom: none; margin-bottom: 0px; }
.profile-tab { padding: 6px 12px; font-size: 13px; color: #535a60; text-decoration: none; border-radius: 100px; cursor: pointer; }
.profile-tab.active { background: #f48225; color: #fff; font-weight: bold; }
.profile-tab:hover:not(.active) { background: #e3e6e8; }

/* Body Area */
.so-profile-body {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    margin-top: 24px;
}

[x-cloak] { display: none !important; }

/* =========================================
   PROFILE TAB STYLES (Ancien design)
   ========================================= */
.prof-layout { display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap; width: 100%; }
.prof-left { width: 220px; flex-shrink: 0; }
.prof-right { flex: 1; min-width: 0; }
.prof-section-title { font-size: 21px; margin: 0 0 12px; color: #232629; font-weight: normal; }
.prof-stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }
.prof-stat-box { border: 1px solid #d6d9dc; border-radius: 4px; padding: 12px; display: flex; flex-direction: column; }
.prof-stat-val { font-size: 17px; color: #232629; margin-bottom: 2px; }
.prof-stat-lbl { font-size: 12px; color: #6a737c; }
.prof-about-box { font-size: 15px; color: #232629; margin-bottom: 32px; line-height: 1.5; }
.prof-badges-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; margin-bottom: 32px; }
.prof-badge-card { border: 1px solid #d6d9dc; border-radius: 4px; padding: 12px; background: #fff; }
.prof-badge-header { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
.prof-b-count { font-size: 24px; font-weight: normal; color: #3b4045; line-height: 1; }
.prof-b-lbl { font-size: 13px; color: #6a737c; text-transform: uppercase; letter-spacing: 0.5px; }
.prof-badge-list { display: flex; flex-wrap: wrap; gap: 4px; }
.prof-b-pill { font-size: 12px; color: #39739d; background: #e1ecf4; padding: 2px 6px; border-radius: 3px; }
.prof-tags-list { border: 1px solid #d6d9dc; border-radius: 4px; margin-bottom: 32px; overflow: hidden; }

/* =========================================
   ACTIVITY TAB STYLES (Le résumé/summary)
   ========================================= */
.so-sidebar-nav {
    width: 140px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.so-sidebar-link {
    padding: 6px 12px;
    border-radius: 100px;
    font-size: 13px;
    color: #525960;
    text-decoration: none;
    cursor: pointer;
}
.so-sidebar-link:hover { background: #e3e6e8; color: #0c0d0e; }
.so-sidebar-link.active { background: #f1f2f3; color: #0c0d0e; font-weight: 600; }

.so-main-content {
    flex: 1;
    min-width: 0;
}

.so-section-header {
    font-size: 21px;
    font-weight: 400;
    color: #232629;
    margin: 0 0 12px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.so-card {
    border: 1px solid #d6d9dc;
    border-radius: 5px;
    background: #fff;
    padding: 16px;
    display: flex;
    flex-direction: column;
}
.so-card-title {
    font-size: 13px;
    color: #6a737c;
    text-transform: uppercase;
    margin-bottom: 12px;
    letter-spacing: 0px;
}
.so-row {
    display: grid;
    gap: 24px;
    margin-bottom: 32px;
}
.so-summary-row { grid-template-columns: 2fr 1.3fr 1fr; }
.so-2col-row { grid-template-columns: 1fr 1fr; }

.so-rep-val { font-size: 32px; color: #232629; line-height: 1; margin-bottom: 4px; }
.so-rep-rank { font-size: 13px; color: #0074cc; font-weight: 600; }
.so-progress-lines { margin-top: auto; padding-top: 16px; }
.so-progress-row { display: flex; justify-content: space-between; font-size: 12px; color: #6a737c; margin-bottom: 4px; }
.so-bar-bg { height: 4px; background: #e3e6e8; border-radius: 4px; overflow: hidden; margin-bottom: 12px; }
.so-bar-fill { height: 100%; background: #2e8b57; }

.so-badges-flex { display: flex; gap: 8px; margin-bottom: 16px; }
.so-badge-square { flex: 1; border: 1px solid #d6d9dc; border-radius: 3px; padding: 6px; text-align: center; font-size: 15px; font-weight: 500; color: #3b4045; display: flex; align-items: center; justify-content: center; gap: 6px; }
.b-dot { width: 10px; height: 10px; border-radius: 50%; display:inline-block; }
.b-dot.gold { background: #ffcc01; }
.b-dot.silver { background: #b4b8bc; }
.b-dot.bronze { background: #d1a684; }

.so-impact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.so-impact-item { display: flex; flex-direction: column; }
.so-impact-num { font-size: 17px; color: #232629; margin-bottom: 2px; }
.so-impact-txt { font-size: 12px; color: #6a737c; }

.so-list-box { border: 1px solid #d6d9dc; border-radius: 5px; background: #fff; overflow: hidden; }
.so-list-header { display: flex; background: #f8f9f9; border-bottom: 1px solid #d6d9dc; padding: 10px 12px; justify-content: space-between; align-items: center; }
.so-list-item { display: flex; gap: 12px; padding: 10px 12px; border-bottom: 1px solid #e3e6e8; align-items: center; }
.so-list-item:last-child { border-bottom: none; }

.so-score-box { display: inline-flex; align-items: center; justify-content: center; min-width: 44px; height: 28px; border-radius: 3px; font-size: 13px; font-weight: 600; flex-shrink: 0; }
.so-score-box.green { background: #5eba7d; color: #fff; border: 1px solid transparent; }
.so-score-box.white { background: #fff; color: #6a737c; border: 1px solid #d6d9dc; }
.so-title-link { font-size: 15px; color: #0074cc; text-decoration: none; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.so-title-link:hover { color: #0a95ff; }
.so-date { font-size: 12px; color: #6a737c; flex-shrink: 0; }

.so-tag-badge { background: #e1ecf4; color: #39739d; font-size: 12px; padding: 4px 8px; border-radius: 3px; text-decoration: none; align-items:center; display:inline-flex;}
.so-tag-stats { font-size: 13px; color: #6a737c; }
.so-tag-stats strong { color: #232629; font-weight: 600; }

.so-badges-detailed { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px; }
.so-badge-lg { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 16px; }
.so-bdg-icon { width: 48px; height: 48px; border-radius: 50%; display:inline-block; flex-shrink: 0; }
.so-bdg-icon.gold { background: linear-gradient(135deg, #fcd000, #b29100); }
.so-bdg-icon.silver { background: linear-gradient(135deg, #e8e8e8, #9fa6ad); }
.so-bdg-icon.bronze { background: linear-gradient(135deg, #f0c39f, #ab825f); }

.so-bdg-info { display: flex; flex-direction: column; }
.so-bdg-count { font-size: 26px; color: #232629; font-weight: bold; line-height: 1; margin-bottom: 4px; }
.so-bdg-label { font-size: 13px; color: #6a737c; }
.so-sub-badge-list { display: flex; flex-direction: column; gap: 6px; }
.so-sub-badge { display: flex; justify-content: space-between; align-items: center; }
.so-badge-pill { font-size: 12px; color: #3b4045; background: #fff; border: 1px solid #d6d9dc; padding: 2px 6px; border-radius: 3px; display: inline-flex; align-items: center; gap: 4px; }
.so-sub-date { font-size: 12px; color: #6a737c; }

@media (max-width: 900px) {
    .so-summary-row { grid-template-columns: 1fr; }
    .so-2col-row { grid-template-columns: 1fr; }
    .so-badges-detailed { grid-template-columns: 1fr; }
    .prof-layout { flex-direction: column; }
    .prof-left { width: 100%; display: flex; flex-wrap: wrap; gap: 12px; }
}
@media (max-width: 600px) {
    .so-profile-body { flex-direction: column; }
    .so-sidebar-nav { width: 100%; flex-direction: row; flex-wrap: wrap; }
}
</style>

@php
    $ac=['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2','#c026d3','#0284c7'];
    $ci=abs(crc32($user->name))%count($ac);
@endphp

<div class="so-profile-container" x-data="{ tab: 'profile', subtab: 'summary' }">

    <!-- HEADER -->
    <div class="profile-header">
        <div class="profile-avatar" style="background:{{ $ac[$ci] }}">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="profile-info">
            <h1 class="profile-name">{{ $user->name }}</h1>
            <div class="profile-meta">
                <div class="profile-meta-item">
                    <svg width="15" height="15" viewBox="0 0 18 18" fill="currentColor" opacity="0.5" style="vertical-align: middle;">
                        <path d="M1 6l8 5 8-5V4L9 9 1 4v2z"/>
                        <path d="M1 8l8 5 8-5v2l-8 5-8-5V8z"/>
                    </svg>
                    Membre depuis {{ $user->created_at->format('M Y') }}
                </div>
                @if($user->campus)
                    <div class="profile-meta-item" style="color: #6a737c; margin-left: 8px;">
                        <svg width="15" height="15" viewBox="0 0 18 18" fill="currentColor" opacity="0.5" style="vertical-align: middle;">
                            <path d="M9 2a6 6 0 00-6 6c0 4.5 6 9 6 9s6-4.5 6-9a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                        {{ $user->campus }}
                    </div>
                @endif
                @if($user->is_moderator)
                    <div class="profile-meta-item" style="color: #d93025; font-weight: bold;">
                        Modérateur
                    </div>
                @endif
            </div>

            @if(auth()->id() === $user->id)
                <div style="margin-top: 12px; display: flex; gap: 8px;">
                    <a href="{{ route('profile.edit') }}" style="padding: 8px 12px; font-size: 13px; background: #fff; color: #6a737c; border: 1px solid #babfc4; border-radius: 3px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 01.708 0l3 3a.5.5 0 010 .708l-10 10a.5.5 0 01-.168.11l-5 2a.5.5 0 01-.65-.65l2-5a.5.5 0 01.11-.168l10-10z"/>
                        </svg>
                        Modifier le profil
                    </a>
                </div>
            @endif


            <!-- Tabs -->
            <div class="profile-tabs">
                <div class="profile-tab" :class="{'active': tab === 'profile'}" @click="tab = 'profile'">Profil</div>
                <div class="profile-tab" :class="{'active': tab === 'activity'}" @click="tab = 'activity'">Activité</div>
            </div>
        </div>
    </div>


    <div class="so-profile-body">
        
        <!-- ==============================================
             ONGLET : PROFIL (Ancien design)
             ============================================== -->
        <div class="prof-layout" x-show="tab === 'profile'" x-cloak>
            <!-- Colonne Gauche -->
            <div class="prof-left">
                <h2 class="prof-section-title">Stats</h2>
                <div class="prof-stats-grid">
                    <div class="prof-stat-box">
                        <div class="prof-stat-val">{{ number_format($user->reputation ?? 0) }}</div>
                        <div class="prof-stat-lbl">réputation</div>
                    </div>
                    <div class="prof-stat-box">
                        <div class="prof-stat-val">{{ number_format($stats['answers_count'] ?? 0) }}</div>
                        <div class="prof-stat-lbl">réponses</div>
                    </div>
                    <div class="prof-stat-box">
                        <div class="prof-stat-val">{{ number_format($stats['questions_count'] ?? 0) }}</div>
                        <div class="prof-stat-lbl">questions</div>
                    </div>
                    <div class="prof-stat-box">
                        <div class="prof-stat-val">{{ number_format($peopleReached ?? 0) }}</div>
                        <div class="prof-stat-lbl">vues</div>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite -->
            <div class="prof-right">
                <h2 class="prof-section-title">À propos</h2>
                <div class="prof-about-box">
                    @if(isset($user->bio) && $user->bio)
                        {{ $user->bio }}
                    @else
                        <i style="color:#6a737c">Cet utilisateur n'a pas encore renseigné sa description.</i>
                    @endif
                </div>

                <h2 class="prof-section-title">Badges</h2>
                <div class="prof-badges-grid">
                    <div class="prof-badge-card">
                        <div class="prof-badge-header">
                            <span class="b-dot gold"></span>
                            <span class="prof-b-count">{{ $badges['gold'] ?? 0 }}</span>
                            <span class="prof-b-lbl">Or</span>
                        </div>
                        <div class="prof-badge-list"><span class="prof-b-pill">excellence</span></div>
                    </div>
                    <div class="prof-badge-card">
                        <div class="prof-badge-header">
                            <span class="b-dot silver"></span>
                            <span class="prof-b-count">{{ $badges['silver'] ?? 0 }}</span>
                            <span class="prof-b-lbl">Argent</span>
                        </div>
                        <div class="prof-badge-list"><span class="prof-b-pill">assiduité</span></div>
                    </div>
                    <div class="prof-badge-card">
                        <div class="prof-badge-header">
                            <span class="b-dot bronze"></span>
                            <span class="prof-b-count">{{ $badges['bronze'] ?? 0 }}</span>
                            <span class="prof-b-lbl">Bronze</span>
                        </div>
                        <div class="prof-badge-list"><span class="prof-b-pill">participation</span></div>
                    </div>
                </div>

                <h2 class="prof-section-title">Top tags</h2>
                <div class="prof-tags-list">
                    @forelse($topTags as $tag)
                        <div class="so-list-item">
                            <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="so-tag-badge">{{ $tag->name }}</a>
                            <div style="flex:1;"></div>
                            <div class="so-tag-stats"><strong>{{ $tag->user_posts_count }}</strong> posts</div>
                        </div>
                    @empty
                        <div class="so-list-item" style="color:#6a737c; padding:16px;">Aucun tag actif.</div>
                    @endforelse
                </div>

                <h2 class="prof-section-title">Top posts</h2>
                <div class="prof-tags-list">
                    @forelse($topQuestions as $post)
                        <div class="so-list-item">
                            <div class="so-score-box {{ $post->vote_score > 0 ? 'green' : 'white' }}">{{ $post->vote_score }}</div>
                            <a href="{{ route('questions.show', $post) }}" class="so-title-link">{{ $post->title }}</a>
                            <div class="so-date">{{ $post->created_at->format('M Y') }}</div>
                        </div>
                    @empty
                        <div class="so-list-item" style="color:#6a737c; padding:16px;">Aucun post pour le moment.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ==============================================
             ONGLET : ACTIVITÉ (Résumé / Summary)
             ============================================== -->
        <template x-if="tab === 'activity'">
            <div style="display:flex; gap:24px; width:100%;">
                
                <!-- SIDEBAR -->
                <nav class="so-sidebar-nav">
                    <a href="#" class="so-sidebar-link" :class="{ 'active': subtab === 'summary' }" @click.prevent="subtab = 'summary'">Résumé</a>
                    <a href="#" class="so-sidebar-link" :class="{ 'active': subtab === 'answers' }" @click.prevent="subtab = 'answers'">Réponses</a>
                    <a href="#" class="so-sidebar-link" :class="{ 'active': subtab === 'questions' }" @click.prevent="subtab = 'questions'">Questions</a>
                    <a href="#" class="so-sidebar-link" :class="{ 'active': subtab === 'tags' }" @click.prevent="subtab = 'tags'">Tags</a>
                    <a href="#" class="so-sidebar-link" :class="{ 'active': subtab === 'badges' }" @click.prevent="subtab = 'badges'">Badges</a>
                    <a href="#" class="so-sidebar-link" :class="{ 'active': subtab === 'reputation' }" @click.prevent="subtab = 'reputation'">Réputation</a>
                </nav>

                <!-- MAIN -->
                <div class="so-main-content">

                    <!-- SOUS-ONGLET : SUMMARY -->
                    <div x-show="subtab === 'summary'">
                        <!-- LIGNE 1 : Résumé, Badges, Impact -->
                        <h2 class="so-section-header">Résumé</h2>
                        <div class="so-row so-summary-row">
                        
                        <!-- Réputation -->
                        <div class="so-card">
                            <div class="so-card-title">RÉPUTATION</div>
                            <div class="so-rep-val">{{ number_format($user->reputation ?? 0) }}</div>
                            @if(($user->reputation ?? 0) >= 1000)
                                <div class="so-rep-rank">#1 cette semaine</div>
                            @endif
                            
                            <div class="so-progress-lines">
                                <div class="so-progress-row">
                                    <span>Prochain tag badge</span>
                                    <span>{{ min(200, \App\Models\Question::where('user_id', $user->id)->count()) }}/200 réponses</span>
                                </div>
                                <div class="so-bar-bg">
                                    <div class="so-bar-fill" style="width: {{ min(100, (\App\Models\Question::where('user_id', $user->id)->count() / 200) * 100) }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Badges Résumé -->
                        <div class="so-card">
                            <div class="so-card-title">BADGES</div>
                            <div class="so-badges-flex">
                                <div class="so-badge-square" style="border-color:#ffcc01; background: #fffdf5;"><span class="b-dot gold"></span>{{ $badges['gold'] ?? 0 }}</div>
                                <div class="so-badge-square"><span class="b-dot silver"></span>{{ $badges['silver'] ?? 0 }}</div>
                                <div class="so-badge-square"><span class="b-dot bronze"></span>{{ $badges['bronze'] ?? 0 }}</div>
                            </div>
                            <div class="so-progress-row" style="margin-top:auto;">
                                <span>Prochain badge</span>
                                <span>{{ min(100, $user->reputation ?? 0) }}/100</span>
                            </div>
                            <div class="so-bar-bg" style="margin-bottom:0;">
                                <div class="so-bar-fill" style="width: {{ min(100, $user->reputation ?? 0) }}%; background:#ffcc01;"></div>
                            </div>
                        </div>

                        <!-- Impact -->
                        <div class="so-card">
                            <div class="so-card-title">IMPACT</div>
                            <div class="so-impact-grid">
                                <div class="so-impact-item">
                                    <span class="so-impact-num">~{{ number_format($peopleReached ?? 0) }}</span>
                                    <span class="so-impact-txt">personnes atteintes</span>
                                </div>
                                <div class="so-impact-item">
                                    <span class="so-impact-num">{{ number_format(($stats['questions_count'] ?? 0) + ($stats['answers_count'] ?? 0)) }}</span>
                                    <span class="so-impact-txt">posts publiés</span>
                                </div>
                                <div class="so-impact-item">
                                    <span class="so-impact-num">{{ number_format($stats['accepted_answers'] ?? 0) }}</span>
                                    <span class="so-impact-txt">acceptées</span>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- LIGNE 2 : Réponses & Questions -->
                    <div class="so-row so-2col-row">
                        <!-- Réponses -->
                        <div>
                            <h2 class="so-section-header">Réponses <span style="font-size:13px; color:#6a737c; font-weight:normal; margin-left:8px;">Voir les {{ $stats['answers_count'] ?? 0 }} réponses</span></h2>
                            <div class="so-list-box">
                                <div class="so-list-header">
                                    <div style="font-size:12px; color:#6a737c;">Tri par score</div>
                                </div>
                                @forelse($topAnswers as $answer)
                                    <div class="so-list-item">
                                        <div class="so-score-box {{ $answer->vote_score > 0 ? 'green' : 'white' }}">
                                            {{ $answer->vote_score }}
                                        </div>
                                        <a href="{{ route('questions.show', $answer->question) }}" class="so-title-link">{{ $answer->question->title }}</a>
                                        <div class="so-date">{{ $answer->created_at->format('M d, Y') }}</div>
                                    </div>
                                @empty
                                    <div class="so-list-item" style="color:#6a737c;">Aucune réponse pour le moment.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Questions -->
                        <div>
                            <h2 class="so-section-header">Questions <span style="font-size:13px; color:#6a737c; font-weight:normal; margin-left:8px;">Voir les {{ $stats['questions_count'] ?? 0 }} questions</span></h2>
                            <div class="so-list-box">
                                <div class="so-list-header">
                                    <div style="font-size:12px; color:#6a737c;">Tri par score</div>
                                </div>
                                @forelse($topQuestions as $question)
                                    <div class="so-list-item">
                                        <div class="so-score-box {{ $question->vote_score > 0 ? 'green' : 'white' }}">
                                            {{ $question->vote_score }}
                                        </div>
                                        <a href="{{ route('questions.show', $question) }}" class="so-title-link">{{ $question->title }}</a>
                                        <div class="so-date">{{ $question->created_at->format('M d, Y') }}</div>
                                    </div>
                                @empty
                                    <div class="so-list-item" style="color:#6a737c;">Aucune question soumise.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>


                    <!-- LIGNE 3 : Tags & Réputation -->
                    <div class="so-row so-2col-row">
                        <!-- Tags -->
                        <div>
                            <h2 class="so-section-header">Tags <span style="font-size:13px; color:#6a737c; font-weight:normal; margin-left:8px;">Voir tous les tags</span></h2>
                            <div class="so-list-box">
                                @forelse($topTags as $tag)
                                    <div class="so-list-item">
                                        <div style="flex-shrink:0;">
                                            <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="so-tag-badge">{{ $tag->name }} <span class="b-dot gold" style="width:6px; height:6px; margin-left:4px;"></span></a>
                                        </div>
                                        <div style="flex:1;"></div>
                                        <div class="so-tag-stats">
                                            <strong>{{ number_format(($tag->user_posts_count ?? 1) * 150) }}</strong> score
                                        </div>
                                        <div class="so-tag-stats" style="margin-left: 12px; width:70px; text-align:right;">
                                            <strong>{{ number_format($tag->user_posts_count) }}</strong> posts
                                        </div>
                                    </div>
                                @empty
                                    <div class="so-list-item" style="color:#6a737c;">Aucun tag actif.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Réputation (Activités fréquentes) -->
                        <div>
                            <h2 class="so-section-header">Réputation</h2>
                            <div class="so-list-box" style="padding: 16px;">
                                <div style="display:flex; align-items:flex-end; gap:4px; height: 40px; margin-bottom: 20px; border-bottom:1px solid #e3e6e8;">
                                    <div style="width:10%; background:#2e8b57; height:20%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:40%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:30%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:70%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:60%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:80%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:30%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:50%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:90%;"></div>
                                    <div style="width:10%; background:#2e8b57; height:40%;"></div>
                                </div>
                                <div style="display:flex; flex-direction:column; gap:12px;">
                                    <div style="display:flex; gap:12px; align-items:flex-start;">
                                        <span class="so-badge-pill" style="color:#2e8b57; border-color:#5eba7d;">+10</span>
                                        <span style="font-size:13px; color:#0074cc; flex:1;">Upvote reçu sur une question</span>
                                    </div>
                                    <div style="display:flex; gap:12px; align-items:flex-start;">
                                        <span class="so-badge-pill" style="color:#2e8b57; border-color:#5eba7d;">+15</span>
                                        <span style="font-size:13px; color:#0074cc; flex:1;">Réponse validée acceptée</span>
                                    </div>
                                    <div style="display:flex; gap:12px; align-items:flex-start;">
                                        <span class="so-badge-pill" style="color:#2e8b57; border-color:#5eba7d;">+10</span>
                                        <span style="font-size:13px; color:#0074cc; flex:1;">Upvote sur un post récent</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LIGNE 4 : Badges détaillés -->
                    <h2 class="so-section-header">Badges <span style="font-size:13px; color:#6a737c; font-weight:normal; margin-left:8px;">Voir tous les badges</span></h2>
                    <div class="so-badges-detailed">
                        <!-- Or -->
                        <div class="so-card" style="margin:0;">
                            <div class="so-badge-lg">
                                <div class="so-bdg-icon gold"></div>
                                <div class="so-bdg-info">
                                    <span class="so-bdg-count">{{ $badges['gold'] ?? 0 }}</span>
                                    <span class="so-bdg-label">badges en or</span>
                                </div>
                            </div>
                            @if(($badges['gold'] ?? 0) > 0)
                            <div class="so-sub-badge-list">
                                <div class="so-sub-badge">
                                    <span class="so-badge-pill"><span class="b-dot gold"></span> excellence</span>
                                    <span class="so-sub-date">Avr 6, 2026</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Argent -->
                        <div class="so-card" style="margin:0;">
                            <div class="so-badge-lg">
                                <div class="so-bdg-icon silver"></div>
                                <div class="so-bdg-info">
                                    <span class="so-bdg-count">{{ $badges['silver'] ?? 0 }}</span>
                                    <span class="so-bdg-label">badges en argent</span>
                                </div>
                            </div>
                            @if(($badges['silver'] ?? 0) > 0)
                            <div class="so-sub-badge-list">
                                <div class="so-sub-badge">
                                    <span class="so-badge-pill"><span class="b-dot silver"></span> assiduité</span>
                                    <span class="so-sub-date">Déc 12, 2025</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Bronze -->
                        <div class="so-card" style="margin:0;">
                            <div class="so-badge-lg">
                                <div class="so-bdg-icon bronze"></div>
                                <div class="so-bdg-info">
                                    <span class="so-bdg-count">{{ $badges['bronze'] ?? 0 }}</span>
                                    <span class="so-bdg-label">badges en bronze</span>
                                </div>
                            </div>
                            @if(($badges['bronze'] ?? 0) > 0)
                            <div class="so-sub-badge-list">
                                <div class="so-sub-badge">
                                    <span class="so-badge-pill"><span class="b-dot bronze"></span> participation</span>
                                    <span class="so-sub-date">Fév 13, 2026</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    </div> <!-- Fin subtab === 'summary' -->

                    <!-- SOUS-ONGLET : REPONSES -->
                    <div x-show="subtab === 'answers'" x-cloak>
                        <h2 class="so-section-header" style="justify-content: flex-start; gap: 24px;">
                            {{ number_format($answers->total()) }} Réponses
                            <div style="font-size:13px; display:inline-flex; border:1px solid #d6d9dc; border-radius:3px; overflow:hidden;">
                                <span style="padding:6px 10px; background:#e3e6e8; border-right:1px solid #d6d9dc; font-weight:600; color:#0c0d0e;">Score</span>
                                <span style="padding:6px 10px; border-right:1px solid #d6d9dc; color:#535a60;">Activité</span>
                                <span style="padding:6px 10px; color:#535a60;">Récents</span>
                            </div>
                        </h2>
                        <div class="so-list-box" style="margin-top: 16px;">
                            @forelse($answers as $ans)
                                <div class="so-list-item" style="align-items:flex-start; padding: 16px;">
                                    <div style="width: 100px; display:flex; flex-direction:column; gap:4px; align-items:flex-end; font-size:13px; color:#6a737c;">
                                        <span>{{ $ans->vote_score ?? 0 }} votes</span>
                                        @if($ans->is_accepted)
                                            <span style="background:#2e8b57; color:#fff; padding:2px 6px; border-radius:3px; font-weight:600;"><svg width="12" height="12" viewBox="0 0 12 12" style="fill:currentColor; display:inline-block; vertical-align:middle; margin-right:2px; margin-top:-2px;"><path d="M10.28 2.28L3.99 8.57 1.72 6.3a1 1 0 0 0-1.42 1.42l3 3a1 1 0 0 0 1.42 0l7-7a1 1 0 0 0-1.42-1.42z"></path></svg>Acceptée</span>
                                        @endif
                                    </div>
                                    <div style="flex:1; margin-left: 16px;">
                                        <a href="{{ route('questions.show', $ans->question) }}" class="so-title-link" style="white-space:normal; line-height:1.4; display:block; margin-bottom:8px;">{{ $ans->question->title }}</a>
                                        <div style="display:flex; justify-content:space-between; align-items:center;">
                                            <div style="display:flex; gap:6px;">
                                                @foreach($ans->question->tags as $t)
                                                    <a href="{{ route('questions.index', ['tag'=>$t->slug]) }}" class="so-tag-badge">{{ $t->name }}</a>
                                                @endforeach
                                            </div>
                                            <div class="so-date">répondu {{ $ans->created_at->format('M d, Y') }} à {{ $ans->created_at->format('H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div style="padding: 16px; color:#6a737c;">Aucune réponse trouvée.</div>
                            @endforelse
                        </div>
                        <div style="margin-top:24px;">{{ $answers->links() }}</div>
                    </div>

                    <!-- SOUS-ONGLET : QUESTIONS -->
                    <div x-show="subtab === 'questions'" x-cloak>
                        <h2 class="so-section-header" style="justify-content: flex-start; gap: 24px;">
                            {{ number_format($questions->total()) }} Questions
                            <div style="font-size:13px; display:inline-flex; border:1px solid #d6d9dc; border-radius:3px; overflow:hidden;">
                                <span style="padding:6px 10px; background:#e3e6e8; border-right:1px solid #d6d9dc; font-weight:600; color:#0c0d0e;">Score</span>
                                <span style="padding:6px 10px; border-right:1px solid #d6d9dc; color:#535a60;">Activité</span>
                                <span style="padding:6px 10px; border-right:1px solid #d6d9dc; color:#535a60;">Récents</span>
                                <span style="padding:6px 10px; color:#535a60;">Vues</span>
                            </div>
                        </h2>
                        <div class="so-list-box" style="margin-top: 16px;">
                            @forelse($questions as $q)
                                <div class="so-list-item" style="align-items:flex-start; padding: 16px;">
                                    <div style="width: 100px; display:flex; flex-direction:column; gap:6px; align-items:flex-end; font-size:13px; color:#6a737c;">
                                        <span>{{ $q->vote_score ?? 0 }} votes</span>
                                        <span style="{{ $q->answers_count > 0 ? 'border:1px solid #5eba7d; color:#2e8b57;' : 'border:1px solid transparent;' }} padding:2px 6px; border-radius:3px;">
                                            @if($q->answers_count > 0)
                                                <svg width="12" height="12" viewBox="0 0 12 12" style="fill:currentColor; display:inline-block; vertical-align:middle; margin-right:2px; margin-top:-2px;"><path d="M10.28 2.28L3.99 8.57 1.72 6.3a1 1 0 0 0-1.42 1.42l3 3a1 1 0 0 0 1.42 0l7-7a1 1 0 0 0-1.42-1.42z"></path></svg>
                                            @endif
                                            {{ $q->answers_count ?? 0 }} réponses
                                        </span>
                                        <span style="color:#d93025;">{{ number_format($q->views) }} vues</span>
                                    </div>
                                    <div style="flex:1; margin-left: 16px;">
                                        <a href="{{ route('questions.show', $q) }}" class="so-title-link" style="white-space:normal; line-height:1.4; display:block; margin-bottom:8px;">{{ $q->title }}</a>
                                        <div style="display:flex; justify-content:space-between; align-items:center;">
                                            <div style="display:flex; gap:6px;">
                                                @foreach($q->tags as $t)
                                                    <a href="{{ route('questions.index', ['tag'=>$t->slug]) }}" class="so-tag-badge">{{ $t->name }}</a>
                                                @endforeach
                                            </div>
                                            <div class="so-date">demandé {{ $q->created_at->format('M d, Y') }} à {{ $q->created_at->format('H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div style="padding: 16px; color:#6a737c;">Aucune question trouvée.</div>
                            @endforelse
                        </div>
                        <div style="margin-top:24px;">{{ $questions->links() }}</div>
                    </div>

                    <!-- SOUS-ONGLET : TAGS -->
                    <div x-show="subtab === 'tags'" x-cloak>
                        <h2 class="so-section-header" style="justify-content: flex-start; gap: 24px;">
                            {{ number_format(count($allTags)) }} Tags
                            <div style="font-size:13px; display:inline-flex; border:1px solid #d6d9dc; border-radius:3px; overflow:hidden;">
                                <span style="padding:6px 10px; background:#e3e6e8; border-right:1px solid #d6d9dc; font-weight:600; color:#0c0d0e;">Score</span>
                                <span style="padding:6px 10px; color:#535a60;">Nom</span>
                            </div>
                        </h2>
                        <div class="so-list-box" style="margin-top: 16px;">
                            @forelse($allTags as $t)
                                <div class="so-list-item" style="padding: 16px; align-items:center;">
                                    <div style="width: 150px;">
                                        <a href="{{ route('questions.index', ['tag'=>$t->slug]) }}" class="so-tag-badge">{{ $t->name }}  <span class="b-dot gold" style="width:6px; height:6px; margin-left:6px;"></span></a>
                                    </div>
                                    <div style="flex:1;"></div>
                                    <div style="width: 120px; font-size:13px; color:#6a737c; text-align:right;">
                                        <span style="color:#0c0d0e; font-weight:bold;">{{ number_format(($t->user_posts_count ?? 1) * 150) }}</span> score
                                    </div>
                                    <div style="width: 120px; font-size:13px; color:#6a737c; text-align:right;">
                                        <span style="color:#0c0d0e; font-weight:bold;">{{ number_format($t->user_posts_count) }}</span> posts
                                    </div>
                                </div>
                            @empty
                                <div style="padding: 16px; color:#6a737c;">Aucun tag renseigné.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- SOUS-ONGLET : REPUTATION -->
                    <div x-show="subtab === 'reputation'" x-cloak>
                        <h2 class="so-section-header" style="justify-content: flex-start; gap: 24px;">
                            {{ number_format($user->reputation) }} Réputation
                            <div style="font-size:13px; display:inline-flex; border:1px solid #d6d9dc; border-radius:3px; overflow:hidden;">
                                <span style="padding:6px 10px; background:#e3e6e8; border-right:1px solid #d6d9dc; font-weight:600; color:#0c0d0e;">Post</span>
                                <span style="padding:6px 10px; border-right:1px solid #d6d9dc; color:#535a60;">Temp</span>
                                <span style="padding:6px 10px; color:#535a60;">Graphique</span>
                            </div>
                        </h2>
                        <div class="so-list-box" style="margin-top: 16px;">
                            @if(count($activities) > 0)
                                <div class="so-list-header" style="background:#fff; border-bottom:1px solid #e3e6e8; font-weight:bold; color:#2e8b57;">
                                    <span style="margin-left:50px;">Activité récente (+{{ rand(10,50) }})</span><span style="font-size:12px; font-weight:normal; color:#6a737c;">Récemment</span>
                                </div>
                            @endif
                            @forelse($activities as $act)
                                @php 
                                    $isPos = $act['score'] >= 0; 
                                    $scoreDisplay = $isPos ? '+'.($act['score'] == 0 ? array_rand([10=>1, 15=>2]) : $act['score']*10) : ($act['score']*5);
                                @endphp
                                <div class="so-list-item" style="padding: 12px 16px; border-bottom:1px solid #f1f2f3;">
                                    <div style="width: 80px; text-align:right; font-size:13px; color:#6a737c;">
                                        {{ $act['type'] == 'question' ? 'post' : 'réponse' }}
                                    </div>
                                    <div style="width: 50px; text-align:center;">
                                        <span style="font-size:13px; font-weight:bold; border-radius:3px; color: {{ $isPos ? '#2e8b57' : '#d93025'}};">
                                            {{ $scoreDisplay }}
                                        </span>
                                    </div>
                                    <div style="flex:1;">
                                        <a href="{{ $act['type'] == 'question' ? route('questions.show', $act['model']) : route('questions.show', $act['model']->question) }}" class="so-title-link" style="font-size:14px; white-space:normal;">
                                            {{ $act['type'] == 'question' ? $act['model']->title : $act['model']->question->title }}
                                        </a>
                                    </div>
                                    <div style="font-size:12px; color:#6a737c;">{{ $act['date']->diffForHumans() }}</div>
                                </div>
                            @empty
                                <div style="padding: 16px; color:#6a737c;">Aucune activité récente à afficher.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- SOUS-ONGLET : BADGES -->
                    <div x-show="subtab === 'badges'" x-cloak>
                        <h2 class="so-section-header" style="justify-content: flex-start; gap: 24px;">
                            {{ ($badges['gold']??0) + ($badges['silver']??0) + ($badges['bronze']??0) + count($allTags) }} Badges
                            <div style="font-size:13px; display:inline-flex; border:1px solid #d6d9dc; border-radius:3px; overflow:hidden;">
                                <span style="padding:6px 10px; background:#e3e6e8; border-right:1px solid #d6d9dc; font-weight:600; color:#0c0d0e;">Récents</span>
                                <span style="padding:6px 10px; border-right:1px solid #d6d9dc; color:#535a60;">Classe</span>
                                <span style="padding:6px 10px; color:#535a60;">Nom</span>
                            </div>
                        </h2>
                        
                        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:16px; margin-top:24px;">
                            <!-- Badges standards -->
                            @if(($badges['gold']??0)>0)
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="background:#3b4045; color:#fff; font-size:12px; padding:4px 8px; border-radius:3px; display:inline-flex; align-items:center;"><span class="b-dot gold" style="margin-right:6px;"></span> Excellence</span>
                                    <span style="font-size:12px; color:#6a737c;">× {{ $badges['gold'] }}</span>
                                </div>
                            @endif
                            @if(($badges['silver']??0)>0)
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="background:#3b4045; color:#fff; font-size:12px; padding:4px 8px; border-radius:3px; display:inline-flex; align-items:center;"><span class="b-dot silver" style="margin-right:6px;"></span> Assiduité</span>
                                    <span style="font-size:12px; color:#6a737c;">× {{ $badges['silver'] }}</span>
                                </div>
                            @endif
                            @if(($badges['bronze']??0)>0)
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="background:#3b4045; color:#fff; font-size:12px; padding:4px 8px; border-radius:3px; display:inline-flex; align-items:center;"><span class="b-dot bronze" style="margin-right:6px;"></span> Participation</span>
                                    <span style="font-size:12px; color:#6a737c;">× {{ $badges['bronze'] }}</span>
                                </div>
                            @endif

                            <!-- Badges de Tags (générés dynamiquement) -->
                            @foreach($allTags as $t)
                                @php 
                                    $classe = $t->user_posts_count > 10 ? 'gold' : ($t->user_posts_count > 5 ? 'silver' : 'bronze'); 
                                @endphp
                                <div style="display:flex; align-items:center;">
                                    <span style="background:#fff; border:1px solid #d6d9dc; color:#39739d; font-size:12px; padding:2px 8px; border-radius:3px; display:inline-flex; align-items:center;"><span class="b-dot {{ $classe }}" style="margin-right:6px;"></span> {{ $t->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </template>
        
    </div>
</div>

</x-app-layout>
