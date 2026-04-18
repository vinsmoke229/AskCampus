<x-app-layout>

{{-- ══════════════════════════════════════════
     SEARCH PAGE - Style Stack Overflow
══════════════════════════════════════════ --}}

<style>
    .search-page-title { font-size: 27px; font-weight: 400; color: #232629; margin: 0 0 4px; }
    .search-meta { font-size: 13px; color: #6a737c; margin-bottom: 16px; }

    /* Onglets */
    .search-tabs { display: flex; gap: 0; border-bottom: 1px solid #e3e6e8; margin-bottom: 16px; }
    .search-tab {
        padding: 10px 14px; font-size: 13px; color: #6a737c;
        border: 1px solid transparent; border-bottom: none;
        border-radius: 3px 3px 0 0; cursor: pointer;
        text-decoration: none; margin-bottom: -1px;
        transition: color .1s;
    }
    .search-tab:hover { color: #232629; background: #f8f9f9; }
    .search-tab.active {
        color: #232629; font-weight: 700;
        background: #fff; border-color: #e3e6e8;
        border-bottom-color: #fff;
    }
    .tab-count {
        display: inline-block; padding: 1px 6px; font-size: 11px;
        background: #e3e6e8; color: #6a737c; border-radius: 10px;
        margin-left: 4px; font-weight: 400;
    }
    .search-tab.active .tab-count { background: #f48225; color: #fff; }

    /* Résultats questions */
    .result-item {
        padding: 12px 0; border-bottom: 1px solid #e3e6e8;
        display: flex; gap: 12px;
    }
    .result-item:last-child { border-bottom: none; }
    .result-stats {
        display: flex; flex-direction: column; align-items: flex-end;
        gap: 4px; min-width: 80px; flex-shrink: 0;
    }
    .stat-badge {
        padding: 4px 8px; font-size: 12px; border-radius: 3px;
        border: 1px solid #d6d9dc; color: #6a737c; text-align: center;
        min-width: 60px;
    }
    .stat-badge.accepted { background: #5eba7d; border-color: #5eba7d; color: #fff; }
    .result-body { flex: 1; min-width: 0; }
    .result-title {
        font-size: 17px; color: #0074cc; font-weight: 400;
        text-decoration: none; line-height: 1.4; display: block; margin-bottom: 6px;
    }
    .result-title:hover { color: #0a95ff; }
    .result-excerpt { font-size: 13px; color: #3b4045; line-height: 1.5; margin-bottom: 8px; }
    .result-footer { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .result-tag {
        padding: 3px 6px; font-size: 12px;
        background: #e1ecf4; color: #39739d; border-radius: 3px;
        text-decoration: none;
    }
    .result-tag:hover { background: #d0e3f1; }
    .result-author { font-size: 12px; color: #6a737c; margin-left: auto; }
    .result-author a { color: #0074cc; }
    .result-author a:hover { color: #0a95ff; }

    /* Résultats users */
    .users-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
    }
    @media (max-width: 900px) { .users-grid { grid-template-columns: repeat(2, 1fr); } }
    .user-card {
        border: 1px solid #e3e6e8; border-radius: 3px; padding: 12px;
        display: flex; gap: 10px; align-items: flex-start;
        transition: box-shadow .1s;
    }
    .user-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,.1); }
    .user-avatar {
        width: 40px; height: 40px; border-radius: 3px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 16px; color: #fff; flex-shrink: 0;
    }
    .user-info { flex: 1; min-width: 0; }
    .user-name { font-size: 13px; color: #0074cc; text-decoration: none; display: block; }
    .user-name:hover { color: #0a95ff; }
    .user-rep { font-size: 12px; color: #6a737c; margin-top: 2px; }
    .user-rep strong { color: #232629; }

    /* Résultats tags */
    .tags-results-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
    }
    @media (max-width: 900px) { .tags-results-grid { grid-template-columns: repeat(2, 1fr); } }
    .tag-result-card {
        border: 1px solid #e3e6e8; border-radius: 3px; padding: 12px;
        transition: box-shadow .1s;
    }
    .tag-result-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,.1); }
    .tag-result-name {
        display: inline-block; padding: 4px 6px; font-size: 12px;
        background: #e1ecf4; color: #39739d; border-radius: 3px;
        text-decoration: none; margin-bottom: 8px;
    }
    .tag-result-name:hover { background: #d0e3f1; }
    .tag-result-desc { font-size: 13px; color: #3b4045; line-height: 1.5; margin-bottom: 8px; }
    .tag-result-count { font-size: 12px; color: #6a737c; }
    .tag-result-count strong { color: #232629; }

    /* Empty */
    .search-empty { text-align: center; padding: 48px 24px; color: #6a737c; }
    .search-empty-title { font-size: 21px; font-weight: 400; color: #232629; margin-bottom: 8px; }

    /* Pagination */
    .so-pagination { display: flex; gap: 4px; margin-top: 20px; }
    .so-page-btn {
        padding: 6px 10px; font-size: 13px; border: 1px solid #d6d9dc;
        border-radius: 3px; color: #6a737c; background: #fff;
        text-decoration: none; transition: all .1s;
    }
    .so-page-btn:hover { background: #f8f9f9; }
    .so-page-btn.active { background: #f48225; border-color: #f48225; color: #fff; font-weight: 700; }
    .so-page-btn.disabled { opacity: .5; pointer-events: none; }
</style>

<div>
    {{-- Titre --}}
    <h1 class="search-page-title">
        @if($query)
            Résultats pour "{{ $query }}"
        @else
            Recherche
        @endif
    </h1>

    @if($query)
        <p class="search-meta">
            @if($tab === 'questions' && method_exists($questions, 'total'))
                {{ number_format($questions->total()) }} résultat(s) dans les questions
            @elseif($tab === 'users' && method_exists($users, 'total'))
                {{ number_format($users->total()) }} utilisateur(s) trouvé(s)
            @elseif($tab === 'tags' && method_exists($tags, 'total'))
                {{ number_format($tags->total()) }} tag(s) trouvé(s)
            @endif
        </p>
    @endif

    {{-- Onglets --}}
    <div class="search-tabs">
        <a href="{{ route('search', ['q' => $query, 'tab' => 'questions']) }}"
           class="search-tab {{ $tab === 'questions' ? 'active' : '' }}">
            Questions
            @if($query && method_exists($questions, 'total'))
                <span class="tab-count">{{ $questions->total() }}</span>
            @endif
        </a>
        <a href="{{ route('search', ['q' => $query, 'tab' => 'users']) }}"
           class="search-tab {{ $tab === 'users' ? 'active' : '' }}">
            Utilisateurs
            @if($query && method_exists($users, 'total'))
                <span class="tab-count">{{ $users->total() }}</span>
            @endif
        </a>
        <a href="{{ route('search', ['q' => $query, 'tab' => 'tags']) }}"
           class="search-tab {{ $tab === 'tags' ? 'active' : '' }}">
            Tags
            @if($query && method_exists($tags, 'total'))
                <span class="tab-count">{{ $tags->total() }}</span>
            @endif
        </a>
    </div>

    {{-- Formulaire de recherche --}}
    @if(!$query)
        <form method="GET" action="{{ route('search') }}" style="margin-bottom:24px;">
            <div style="display:flex;gap:8px;max-width:500px;">
                <input type="text" name="q" value="{{ $query }}"
                       placeholder="Rechercher des questions, utilisateurs, tags…"
                       style="flex:1;padding:9px 12px;font-size:15px;border:1px solid #babfc4;
                              border-radius:3px;outline:none;"
                       autofocus>
                <button type="submit"
                        style="padding:9px 16px;background:#0074cc;color:#fff;border:none;
                               border-radius:3px;font-size:13px;cursor:pointer;">
                    Rechercher
                </button>
            </div>
        </form>
    @endif

    {{-- ══════ ONGLET QUESTIONS ══════ --}}
    @if($tab === 'questions')
        @if($query && method_exists($questions, 'count') && $questions->count() > 0)
            <div>
                @foreach($questions as $question)
                    @php
                        $voteScore = $question->votes->sum('value');
                        $answerCount = $question->answers->count();
                        $hasAccepted = $question->answers->where('is_accepted', true)->count() > 0;
                    @endphp
                    <div class="result-item">
                        <div class="result-stats">
                            <div class="stat-badge">
                                <div style="font-size:15px;font-weight:700;color:{{ $voteScore > 0 ? '#232629' : '#6a737c' }}">
                                    {{ $voteScore }}
                                </div>
                                <div style="font-size:11px;">votes</div>
                            </div>
                            <div class="stat-badge {{ $hasAccepted ? 'accepted' : '' }}">
                                <div style="font-size:15px;font-weight:700;">{{ $answerCount }}</div>
                                <div style="font-size:11px;">réponses</div>
                            </div>
                        </div>
                        <div class="result-body">
                            <a href="{{ route('questions.show', $question) }}" class="result-title">
                                {{ $question->title }}
                            </a>
                            <p class="result-excerpt">
                                {{ Str::limit(strip_tags($question->body), 150) }}
                            </p>
                            <div class="result-footer">
                                @foreach($question->tags as $tag)
                                    <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="result-tag">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                                <span class="result-author">
                                    posée {{ $question->created_at->diffForHumans() }} par
                                    <a href="{{ route('users.show', $question->user) }}">{{ $question->user->name }}</a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- Pagination --}}
            @if($questions->hasPages())
                <div class="so-pagination">
                    @if($questions->onFirstPage())
                        <span class="so-page-btn disabled">‹ Préc</span>
                    @else
                        <a href="{{ $questions->previousPageUrl() }}" class="so-page-btn">‹ Préc</a>
                    @endif
                    @foreach($questions->getUrlRange(1, $questions->lastPage()) as $page => $url)
                        @if($page == $questions->currentPage())
                            <span class="so-page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="so-page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($questions->hasMorePages())
                        <a href="{{ $questions->nextPageUrl() }}" class="so-page-btn">Suiv ›</a>
                    @else
                        <span class="so-page-btn disabled">Suiv ›</span>
                    @endif
                </div>
            @endif
        @elseif($query)
            <div class="search-empty">
                <h2 class="search-empty-title">Aucune question trouvée</h2>
                <p>Aucune question ne correspond à "{{ $query }}".</p>
            </div>
        @endif
    @endif

    {{-- ══════ ONGLET USERS ══════ --}}
    @if($tab === 'users')
        @if($query && method_exists($users, 'count') && $users->count() > 0)
            @php
                $avatarColors = ['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2'];
            @endphp
            <div class="users-grid">
                @foreach($users as $user)
                    @php $ci = abs(crc32($user->name)) % count($avatarColors); @endphp
                    <a href="{{ route('users.show', $user) }}" class="user-card" style="text-decoration:none;">
                        <div class="user-avatar" style="background:{{ $avatarColors[$ci] }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ $user->name }}</span>
                            <div class="user-rep">
                                <strong>{{ number_format($user->reputation ?? 0) }}</strong> réputation
                            </div>
                            <div style="font-size:11px;color:#9fa6ad;margin-top:2px;">
                                Membre depuis {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            @if($users->hasPages())
                <div class="so-pagination">
                    @if($users->onFirstPage())
                        <span class="so-page-btn disabled">‹ Préc</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="so-page-btn">‹ Préc</a>
                    @endif
                    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if($page == $users->currentPage())
                            <span class="so-page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="so-page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="so-page-btn">Suiv ›</a>
                    @else
                        <span class="so-page-btn disabled">Suiv ›</span>
                    @endif
                </div>
            @endif
        @elseif($query)
            <div class="search-empty">
                <h2 class="search-empty-title">Aucun utilisateur trouvé</h2>
                <p>Aucun utilisateur ne correspond à "{{ $query }}".</p>
            </div>
        @endif
    @endif

    {{-- ══════ ONGLET TAGS ══════ --}}
    @if($tab === 'tags')
        @if($query && method_exists($tags, 'count') && $tags->count() > 0)
            <div class="tags-results-grid">
                @foreach($tags as $tag)
                    <div class="tag-result-card">
                        <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="tag-result-name">
                            {{ $tag->name }}
                        </a>
                        <p class="tag-result-desc">
                            {{ Str::limit($tag->description ?? 'Pour les questions relatives à ' . $tag->name . '.', 100) }}
                        </p>
                        <div class="tag-result-count">
                            <strong>{{ number_format($tag->questions_count) }}</strong>
                            question{{ $tag->questions_count > 1 ? 's' : '' }}
                        </div>
                    </div>
                @endforeach
            </div>
            @if($tags->hasPages())
                <div class="so-pagination">
                    @if($tags->onFirstPage())
                        <span class="so-page-btn disabled">‹ Préc</span>
                    @else
                        <a href="{{ $tags->previousPageUrl() }}" class="so-page-btn">‹ Préc</a>
                    @endif
                    @foreach($tags->getUrlRange(1, $tags->lastPage()) as $page => $url)
                        @if($page == $tags->currentPage())
                            <span class="so-page-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="so-page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($tags->hasMorePages())
                        <a href="{{ $tags->nextPageUrl() }}" class="so-page-btn">Suiv ›</a>
                    @else
                        <span class="so-page-btn disabled">Suiv ›</span>
                    @endif
                </div>
            @endif
        @elseif($query)
            <div class="search-empty">
                <h2 class="search-empty-title">Aucun tag trouvé</h2>
                <p>Aucun tag ne correspond à "{{ $query }}".</p>
            </div>
        @endif
    @endif

</div>

</x-app-layout>
