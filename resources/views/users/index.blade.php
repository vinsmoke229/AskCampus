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
        display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;
    }

    /* Carte utilisateur */
    .user-card {
        padding: 6px; display: flex; gap: 8px; align-items: flex-start;
        text-decoration: none; color: inherit; border-radius: 3px;
    }

    .user-avatar {
        width: 48px; height: 48px; border-radius: 4px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 20px; color: #fff; flex-shrink: 0;
    }

    .user-info { flex: 1; min-width: 0; }
    .user-name {
        font-size: 13px; color: #0074cc; font-weight: 400;
        display: block; margin-bottom: 2px; white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
    }
    .user-name:hover { color: #0a95ff; }

    .user-rep {
        font-size: 12px; font-weight: 700; color: #6a737c; margin-bottom: 2px;
    }

    .user-badges { display: flex; gap: 4px; flex-wrap: wrap; }
    .badge-mod {
        padding: 0 4px; font-size: 10px; font-weight: 700;
        background: #dc2626; color: #fff; border-radius: 2px;
    }
    .badge-new {
        padding: 0 4px; font-size: 10px; font-weight: 700;
        background: #5eba7d; color: #fff; border-radius: 2px;
    }

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
        <div class="users-grid" id="users-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 12px;">
            @foreach($users as $user)
                @php
                    $ci       = abs(crc32($user->name)) % count($avatarColors);
                    $isNew    = $user->created_at->gte(now()->subDays(7));
                @endphp
                <div class="user-card" style="padding: 8px; display: flex; gap: 12px; align-items: flex-start; text-decoration: none; color: inherit; border-radius: 3px;">
                    <a href="{{ route('users.show', $user) }}" class="user-avatar" style="width: 48px; height: 48px; border-radius: 3px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px; color: #fff; flex-shrink: 0; background:{{ $avatarColors[$ci] }}; text-decoration: none;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </a>
                    
                    <div class="user-info" style="flex: 1; min-width: 0;">
                        <a href="{{ route('users.show', $user) }}" class="user-name" style="font-size: 15px; color: #0074cc; font-weight: 400; display: block; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-decoration: none;">
                            {{ $user->name }}
                        </a>
                        <div style="font-size: 12px; color: #6a737c; margin-bottom: 2px;">{{ $user->campus ?? 'Campus non renseigné' }}</div>
                        <div class="user-rep" style="font-size: 12px; font-weight: 700; color: #535a60; margin-bottom: 4px;">
                            {{ number_format($user->reputation ?? 0) }}
                        </div>
                        
                        @if(isset($user->top_tags) && $user->top_tags->count() > 0)
                            <div class="user-tags" style="font-size: 12px; color: #0074cc; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                @foreach($user->top_tags as $t)
                                    <a href="{{ route('questions.index', ['tag' => $t->slug]) }}" style="color: #0074cc; text-decoration: none;">{{ $t->name }}</a>@if(!$loop->last), @endif
                                @endforeach
                            </div>
                        @endif

                        <div class="user-badges" style="display: flex; gap: 4px; flex-wrap: wrap; margin-top: 4px;">
                            @if($user->is_moderator)
                                <span class="badge-mod" style="padding: 1px 4px; font-size: 10px; font-weight: 700; background: #fff; color: #0074cc; border: 1px solid #0074cc; border-radius: 2px;">MODÉRATEUR</span>
                            @endif
                            @if($isNew)
                                <span class="badge-new" style="padding: 1px 4px; font-size: 10px; font-weight: 700; background: #e1ecf4; color: #39739d; border-radius: 2px;">NOUVEAU</span>
                            @endif
                        </div>
                    </div>
                </div>
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
