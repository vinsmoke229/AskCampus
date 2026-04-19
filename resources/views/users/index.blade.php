<x-app-layout>

{{-- ══════════════════════════════════════════
     USERS PAGE - Style Stack Overflow
══════════════════════════════════════════ --}}

<style>
    /* Header */
    .users-title { font-size: 27px; font-weight: 400; color: #232629; margin: 0 0 16px; }

    /* Barre de contrôles */
    .users-controls {
        display: flex; gap: 12px; align-items: center;
        justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap;
    }
    .users-search { flex: 1; min-width: 200px; max-width: 300px; position: relative; }
    .users-search-icon {
        position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; color: #6a737c; pointer-events: none;
    }
    .users-search-input {
        width: 100%; padding: 8px 12px 8px 36px; font-size: 13px;
        border: 1px solid #babfc4; border-radius: 3px; color: #232629; outline: none;
    }
    .users-search-input:focus { border-color: #6cbbf7; box-shadow: 0 0 0 4px rgba(0,149,255,.15); }

    .users-filters { display: flex; gap: 4px; flex-wrap: wrap; }
    .users-filter-btn {
        padding: 8px 12px; font-size: 13px; background: #fff; color: #6a737c;
        border: 1px solid #babfc4; border-radius: 3px; cursor: pointer; transition: all .1s;
    }
    .users-filter-btn:hover { background: #f8f9f9; }
    .users-filter-btn.active { background: #e3e6e8; color: #232629; font-weight: 700; border-color: #9fa6ad; }

    /* Filtres rapides */
    .quick-filters {
        display: flex; gap: 6px; margin-bottom: 16px; flex-wrap: wrap;
    }
    .quick-filter {
        padding: 5px 12px; font-size: 12px; border-radius: 3px;
        border: 1px solid #d6d9dc; background: #fff; color: #6a737c;
        cursor: pointer; text-decoration: none; transition: all .1s;
    }
    .quick-filter:hover { background: #f8f9f9; }
    .quick-filter.active { background: #e3e6e8; color: #232629; font-weight: 700; border-color: #9fa6ad; }

    /* Grille utilisateurs */
    .users-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
    }
    @media (max-width: 1100px) { .users-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px)  { .users-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px)  { .users-grid { grid-template-columns: 1fr; } }

    /* Carte utilisateur */
    .user-card {
        border: 1px solid #e3e6e8; border-radius: 3px; padding: 14px;
        display: flex; gap: 12px; align-items: flex-start;
        transition: box-shadow .1s; text-decoration: none; color: inherit;
        background: #fff;
    }
    .user-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,.1); }

    .user-avatar {
        width: 48px; height: 48px; border-radius: 3px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 20px; color: #fff; flex-shrink: 0;
    }

    .user-info { flex: 1; min-width: 0; }
    .user-name {
        font-size: 13px; color: #0074cc; font-weight: 400;
        display: block; margin-bottom: 3px; white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
    }
    .user-name:hover { color: #0a95ff; }

    .user-rep {
        font-size: 13px; font-weight: 700; color: #232629; margin-bottom: 4px;
    }
    .user-rep-label { font-size: 11px; font-weight: 400; color: #6a737c; }

    .user-badges { display: flex; gap: 4px; margin-bottom: 6px; flex-wrap: wrap; }
    .badge-mod {
        padding: 1px 5px; font-size: 10px; font-weight: 700;
        background: #dc2626; color: #fff; border-radius: 3px;
    }
    .badge-new {
        padding: 1px 5px; font-size: 10px; font-weight: 700;
        background: #5eba7d; color: #fff; border-radius: 3px;
    }

    .user-stats { display: flex; gap: 10px; font-size: 11px; color: #6a737c; }
    .user-stat strong { color: #232629; font-weight: 700; }

    .user-joined { font-size: 11px; color: #9fa6ad; margin-top: 4px; }

    /* Empty */
    .users-empty { text-align: center; padding: 64px 24px; color: #6a737c; }
    .users-empty-title { font-size: 21px; font-weight: 400; color: #232629; margin-bottom: 8px; }

    /* Pagination */
    .so-pagination { display: flex; gap: 4px; margin-top: 24px; justify-content: center; }
    .so-page-btn {
        padding: 6px 10px; font-size: 13px; border: 1px solid #d6d9dc;
        border-radius: 3px; color: #6a737c; background: #fff;
        text-decoration: none; transition: all .1s;
    }
    .so-page-btn:hover { background: #f8f9f9; }
    .so-page-btn.active { background: #f48225; border-color: #f48225; color: #fff; font-weight: 700; }
    .so-page-btn.disabled { opacity: .5; pointer-events: none; }

    /* Résultats count */
    .users-count { font-size: 13px; color: #6a737c; margin-bottom: 12px; }
</style>

@php
    $avatarColors = ['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2','#db2777','#0284c7'];
@endphp

<div>
    <h1 class="users-title">Utilisateurs</h1>

    {{-- Barre de contrôles --}}
    <div class="users-controls">
        {{-- Recherche AJAX --}}
        <div class="users-search">
            <svg class="users-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                   id="user-search-input"
                   class="users-search-input"
                   placeholder="Rechercher un utilisateur…"
                   value="{{ $query }}"
                   oninput="debounceSearch(this.value)">
        </div>

        {{-- Tri --}}
        <div class="users-filters">
            @foreach(['reputation' => 'Réputation', 'newest' => 'Nouveaux', 'name' => 'Nom'] as $key => $label)
                <a href="{{ route('users.index', ['sort' => $key, 'filter' => $filter, 'q' => $query]) }}"
                   class="users-filter-btn {{ $sort === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Filtres rapides --}}
    <div class="quick-filters">
        <a href="{{ route('users.index', ['sort' => $sort, 'filter' => 'all', 'q' => $query]) }}"
           class="quick-filter {{ $filter === 'all' ? 'active' : '' }}">
            Tous
        </a>
        <a href="{{ route('users.index', ['sort' => $sort, 'filter' => 'moderators', 'q' => $query]) }}"
           class="quick-filter {{ $filter === 'moderators' ? 'active' : '' }}">
            🛡️ Modérateurs
        </a>
        <a href="{{ route('users.index', ['sort' => $sort, 'filter' => 'new', 'q' => $query]) }}"
           class="quick-filter {{ $filter === 'new' ? 'active' : '' }}">
            🌱 Nouveaux (7 jours)
        </a>
    </div>

    {{-- Compteur --}}
    <div class="users-count">
        {{ number_format($users->total()) }} utilisateur{{ $users->total() > 1 ? 's' : '' }}
        @if($query) correspondant à "{{ $query }}" @endif
    </div>

    {{-- Grille --}}
    @if($users->count() > 0)
        <div class="users-grid" id="users-grid">
            @foreach($users as $user)
                @php
                    $ci       = abs(crc32($user->name)) % count($avatarColors);
                    $isNew    = $user->created_at->gte(now()->subDays(7));
                @endphp
                <a href="{{ route('users.show', $user) }}" class="user-card">
                    <div class="user-avatar" style="background:{{ $avatarColors[$ci] }}">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ $user->name }}</span>

                        <div class="user-rep">
                            {{ number_format($user->reputation ?? 0) }}
                            <span class="user-rep-label">réputation</span>
                        </div>

                        <div class="user-badges">
                            @if($user->is_moderator)
                                <span class="badge-mod">MOD</span>
                            @endif
                            @if($isNew)
                                <span class="badge-new">NOUVEAU</span>
                            @endif
                        </div>

                        <div class="user-stats">
                            <span><strong>{{ $user->questions_count }}</strong> q.</span>
                            <span><strong>{{ $user->answers_count }}</strong> rép.</span>
                        </div>

                        <div class="user-joined">
                            Membre {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
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

    @else
        <div class="users-empty">
            <div style="font-size:48px;margin-bottom:12px;">👥</div>
            <h2 class="users-empty-title">Aucun utilisateur trouvé</h2>
            <p>
                @if($query)
                    Aucun utilisateur ne correspond à "{{ $query }}".
                @else
                    Il n'y a pas encore d'utilisateurs.
                @endif
            </p>
        </div>
    @endif
</div>

<script>
// Recherche avec debounce 300ms
let userSearchTimeout = null;
function debounceSearch(value) {
    clearTimeout(userSearchTimeout);
    userSearchTimeout = setTimeout(() => {
        const params = new URLSearchParams(window.location.search);
        params.set('q', value);
        params.delete('page');
        window.location.href = '{{ route('users.index') }}?' + params.toString();
    }, 300);
}
</script>

</x-app-layout>
