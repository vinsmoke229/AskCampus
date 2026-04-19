<x-app-layout>

{{-- ══════════════════════════════════════════
     TAGS PAGE - Stack Overflow Style (enrichi)
══════════════════════════════════════════ --}}

<style>
    .tags-container { max-width: 1264px; margin: 0 auto; }
    /* Header */
    .tags-title { font-size: 27px; font-weight: 400; color: #232629; margin: 0 0 8px; }
    .tags-description { font-size: 15px; color: #3b4045; line-height: 1.5; margin-bottom: 4px; }
    .tags-link { font-size: 13px; color: #0074cc; }
    .tags-link:hover { color: #0a95ff; }

    /* Barre de contrôles */
    .tags-controls {
        display: flex; gap: 12px; align-items: center;
        justify-content: space-between; margin: 16px 0; flex-wrap: wrap;
    }
    .tags-search { flex: 1; min-width: 200px; max-width: 300px; position: relative; }
    .tags-search-icon {
        position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; color: #6a737c; pointer-events: none;
    }
    .tags-search-input {
        width: 100%; padding: 8px 12px 8px 36px; font-size: 13px;
        border: 1px solid #babfc4; border-radius: 3px; color: #232629; outline: none;
    }
    .tags-search-input:focus { border-color: #6cbbf7; box-shadow: 0 0 0 4px rgba(0,149,255,.15); }

    .tags-filters { display: flex; gap: 4px; flex-wrap: wrap; }
    .tags-filter-btn {
        padding: 8px 12px; font-size: 13px; font-weight: 400;
        background: #fff; color: #6a737c; border: 1px solid #babfc4;
        border-radius: 3px; cursor: pointer; transition: all .1s;
    }
    .tags-filter-btn:hover { background: #f8f9f9; }
    .tags-filter-btn.active {
        background: #e3e6e8; color: #232629; font-weight: 700; border-color: #9fa6ad;
    }

    /* Filtres par catégorie */
    .category-filters {
        display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px;
        padding: 10px 12px; background: #f8f9f9;
        border: 1px solid #e3e6e8; border-radius: 3px;
    }
    .category-label { font-size: 12px; color: #6a737c; align-self: center; margin-right: 4px; }
    .cat-btn {
        padding: 4px 10px; font-size: 12px; border-radius: 3px;
        border: 1px solid #d6d9dc; background: #fff; color: #6a737c;
        cursor: pointer; transition: all .1s;
    }
    .cat-btn:hover { background: #e1ecf4; color: #39739d; border-color: #39739d; }
    .cat-btn.active { background: #e1ecf4; color: #39739d; border-color: #39739d; font-weight: 700; }

    /* Grille */
    .tags-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
    }
    @media (max-width: 1024px) { .tags-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px)  { .tags-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px)  { .tags-grid { grid-template-columns: 1fr; } }

    /* Carte tag */
    .tag-card {
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 12px; transition: box-shadow .1s;
    }
    .tag-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,.1); }
    .tag-card[style*="display:none"] { display: none !important; }

    .tag-card-header { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
    .tag-icon { font-size: 16px; flex-shrink: 0; }
    .tag-name {
        display: inline-block; padding: 4px 6px; font-size: 12px;
        background: #e1ecf4; color: #39739d; border-radius: 3px;
<<<<<<< HEAD
        text-decoration: none; margin-bottom: 8px; font-weight: 400;
        align-self: flex-start;
    }
    .tag-name:hover { background: #d0e3f1; }
    
    .tag-description { 
        font-size: 13px; color: #3b4045; line-height: 1.5;
        margin-bottom: 12px; flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3; -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .tag-stats { 
        display: flex; flex-direction: column; gap: 2px;
        font-size: 12px; color: #6a737c;
        border-top: 1px solid #f0f0f0; padding-top: 8px; margin-top: auto;
=======
        text-decoration: none; font-weight: 400;
    }
    .tag-name:hover { background: #d0e3f1; }

    .tag-description {
        font-size: 13px; color: #3b4045; line-height: 1.5; margin-bottom: 10px;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }

    /* Barre de popularité */
    .tag-popularity { margin-bottom: 10px; }
    .popularity-label { font-size: 11px; color: #9fa6ad; margin-bottom: 3px; }
    .popularity-bar-bg {
        height: 4px; background: #e3e6e8; border-radius: 2px; overflow: hidden;
>>>>>>> TCHABODJO
    }
    .popularity-bar-fill {
        height: 100%; background: #f48225; border-radius: 2px;
        transition: width .3s ease;
    }

    /* Stats */
    .tag-stats { display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #6a737c; }
    .tag-questions { font-weight: 700; color: #232629; }
<<<<<<< HEAD
    .tag-activity { color: #6a737c; }
    
=======
    .tag-week { color: #5eba7d; font-weight: 600; }

>>>>>>> TCHABODJO
    /* Pagination */
    .tags-pagination { display: flex; justify-content: center; gap: 4px; margin-top: 24px; }
    .pagination-btn {
        padding: 6px 10px; font-size: 13px; background: #fff; color: #6a737c;
        border: 1px solid #babfc4; border-radius: 3px; cursor: pointer; min-width: 32px; text-align: center;
    }
    .pagination-btn:hover { background: #f8f9f9; }
    .pagination-btn.active { background: #f48225; color: #fff; border-color: #f48225; font-weight: 700; }
    .pagination-btn:disabled { opacity: .5; cursor: not-allowed; }

    /* Empty */
    .tags-empty { text-align: center; padding: 64px 24px; background: #f8f9f9; border: 1px solid #e3e6e8; border-radius: 3px; }
    .tags-empty-title { font-size: 21px; font-weight: 400; color: #232629; margin-bottom: 8px; }
    .tags-empty-text { font-size: 15px; color: #6a737c; }
</style>

@php
    // Récupérer tous les tags avec le nombre de questions
    $allTags = \App\Models\Tag::withCount('questions')
        ->orderByDesc('questions_count')
        ->get();

    // Filtrer par recherche
    if (request('search')) {
        $search = strtolower(request('search'));
        $allTags = $allTags->filter(function($tag) use ($search) {
            return str_contains(strtolower($tag->name), $search) ||
                   str_contains(strtolower($tag->description ?? ''), $search);
        });
    }

    // Tri
    $sortBy = request('sort', 'popular');
    if ($sortBy === 'name') {
        $allTags = $allTags->sortBy('name');
    } elseif ($sortBy === 'new') {
        $allTags = $allTags->sortByDesc('created_at');
    } elseif ($sortBy === 'activity') {
        // Trier par activité récente (questions cette semaine)
        $allTags = $allTags->sortByDesc(function($tag) {
            return $tag->questions()->where('created_at', '>=', now()->subWeek())->count();
        });
    }

    // Max questions pour les barres de popularité
    $maxQuestions = $allTags->max('questions_count') ?: 1;

    // Pagination manuelle
    $perPage     = 36;
    $currentPage = request('page', 1);
    $totalTags   = $allTags->count();
    $totalPages  = ceil($totalTags / $perPage);
    $offset      = ($currentPage - 1) * $perPage;
    $tags        = $allTags->slice($offset, $perPage)->values();

    // Icônes par catégorie (basé sur le nom du tag)
    function getTagIcon(string $name): string {
        $name = strtolower($name);
        $map = [
            'php'        => '🐘', 'laravel'    => '🔴', 'javascript' => '🟡',
            'js'         => '🟡', 'vue'        => '💚', 'react'      => '⚛️',
            'python'     => '🐍', 'java'       => '☕', 'css'        => '🎨',
            'html'       => '🌐', 'sql'        => '🗄️', 'mysql'      => '🗄️',
            'database'   => '🗄️', 'api'        => '🔌', 'git'        => '🌿',
            'docker'     => '🐳', 'linux'      => '🐧', 'mobile'     => '📱',
            'android'    => '🤖', 'ios'        => '🍎', 'design'     => '🎨',
            'ui'         => '🎨', 'ux'         => '🎨', 'security'   => '🔒',
            'test'       => '🧪', 'devops'     => '⚙️', 'cloud'      => '☁️',
            'node'       => '💚', 'typescript' => '🔷', 'c++'        => '⚡',
            'c#'         => '💜', 'ruby'       => '💎', 'go'         => '🔵',
            'rust'       => '🦀', 'swift'      => '🦅', 'kotlin'     => '🟣',
        ];
        foreach ($map as $keyword => $icon) {
            if (str_contains($name, $keyword)) return $icon;
        }
        return '🏷️';
    }

    // Catégories pour le filtre
    $categories = [
        'all'      => 'Tous',
        'frontend' => 'Frontend',
        'backend'  => 'Backend',
        'database' => 'Base de données',
        'mobile'   => 'Mobile',
        'devops'   => 'DevOps',
    ];
    $categoryKeywords = [
        'frontend' => ['html','css','javascript','js','vue','react','angular','typescript','sass','bootstrap','tailwind','ui','ux','design'],
        'backend'  => ['php','laravel','python','java','node','ruby','go','rust','c++','c#','swift','kotlin','api','rest','graphql'],
        'database' => ['sql','mysql','postgresql','mongodb','redis','database','orm','eloquent'],
        'mobile'   => ['android','ios','mobile','flutter','react-native','swift','kotlin'],
        'devops'   => ['docker','linux','git','devops','cloud','aws','ci','cd','nginx','apache'],
    ];
    $activeCategory = request('category', 'all');
@endphp

<div class="tags-container">

    {{-- Header --}}
    <div style="margin-bottom:16px;">
        <h1 class="tags-title">Tags</h1>
        <p class="tags-description">
            Un tag est un mot-clé ou une étiquette qui catégorise votre question avec d'autres questions similaires.
            L'utilisation des bons tags facilite la recherche et la réponse à votre question.
        </p>
        <a href="#" class="tags-link">Afficher tous les synonymes de tags</a>
    </div>

    {{-- Contrôles : recherche + tri --}}
    <div class="tags-controls">
        <div class="tags-search">
            <svg class="tags-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                   id="tag-search-input"
                   class="tags-search-input"
                   placeholder="Filtrer par nom de tag"
                   value="{{ request('search') }}"
                   oninput="filterTagsLive(this.value)">
        </div>

        <div class="tags-filters">
            @foreach(['popular' => 'Populaire', 'name' => 'Nom', 'new' => 'Nouveau', 'activity' => 'Récemment actifs'] as $key => $label)
                <button class="tags-filter-btn {{ $sortBy === $key ? 'active' : '' }}"
                        onclick="window.location.href='{{ route('tags.index') }}?sort={{ $key }}{{ request('search') ? '&search=' . request('search') : '' }}{{ $activeCategory !== 'all' ? '&category=' . $activeCategory : '' }}'">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Filtres par catégorie --}}
    <div class="category-filters">
        <span class="category-label">Catégorie :</span>
        @foreach($categories as $key => $label)
            <button class="cat-btn {{ $activeCategory === $key ? 'active' : '' }}"
                    onclick="window.location.href='{{ route('tags.index') }}?category={{ $key }}&sort={{ $sortBy }}{{ request('search') ? '&search=' . request('search') : '' }}'">
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- Grille de tags --}}
    @if($tags->count() > 0)
        <div class="tags-grid" id="tags-grid">
            @foreach($tags as $tag)
                @php
                    $recentQuestions = $tag->questions()
                        ->where('created_at', '>=', now()->subWeek())
                        ->count();

                    $activityText = $recentQuestions > 0
                        ? $recentQuestions . ' cette semaine'
                        : 'Aucune cette semaine';

                    $popularityPct = $maxQuestions > 0
                        ? round(($tag->questions_count / $maxQuestions) * 100)
                        : 0;

                    $tagIcon = getTagIcon($tag->name);

                    // Déterminer la catégorie du tag pour le filtre JS
                    $tagCats = ['all'];
                    foreach ($categoryKeywords as $cat => $keywords) {
                        foreach ($keywords as $kw) {
                            if (str_contains(strtolower($tag->name), $kw)) {
                                $tagCats[] = $cat;
                                break;
                            }
                        }
                    }
                    $tagCatsJson = json_encode($tagCats);

                    // Masquer si catégorie active ne correspond pas
                    $hidden = ($activeCategory !== 'all' && !in_array($activeCategory, $tagCats));
                @endphp

                <div class="tag-card"
                     data-name="{{ strtolower($tag->name) }}"
                     data-categories="{{ $tagCatsJson }}"
                     @if($hidden) style="display:none;" @endif>

                    <div class="tag-card-header">
                        <span class="tag-icon">{{ $tagIcon }}</span>
                        <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="tag-name">
                            {{ $tag->name }}
                        </a>
                    </div>

                    <p class="tag-description">
                        {{ $tag->description ?? 'Pour les questions relatives à ' . $tag->name . '.' }}
                    </p>

                    {{-- Barre de popularité --}}
                    <div class="tag-popularity">
                        <div class="popularity-label">Popularité relative</div>
                        <div class="popularity-bar-bg">
                            <div class="popularity-bar-fill" style="width: {{ $popularityPct }}%;"></div>
                        </div>
                    </div>

                    <div class="tag-stats">
                        <span class="tag-questions">
                            {{ number_format($tag->questions_count) }}
                            question{{ $tag->questions_count > 1 ? 's' : '' }}
                        </span>
                        <span class="tag-week">{{ $activityText }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($totalPages > 1)
            <div class="tags-pagination">
                <button class="pagination-btn" {{ $currentPage <= 1 ? 'disabled' : '' }}
                        onclick="window.location.href='{{ route('tags.index') }}?page={{ $currentPage - 1 }}&sort={{ $sortBy }}{{ request('search') ? '&search=' . request('search') : '' }}'">
                    ‹
                </button>
                @for($i = 1; $i <= min($totalPages, 10); $i++)
                    @if($i == 1 || $i == $totalPages || abs($i - $currentPage) <= 2)
                        <button class="pagination-btn {{ $i == $currentPage ? 'active' : '' }}"
                                onclick="window.location.href='{{ route('tags.index') }}?page={{ $i }}&sort={{ $sortBy }}{{ request('search') ? '&search=' . request('search') : '' }}'">
                            {{ $i }}
                        </button>
                    @elseif($i == 2 && $currentPage > 4)
                        <span class="pagination-btn" style="border:none;cursor:default;">...</span>
                    @elseif($i == $totalPages - 1 && $currentPage < $totalPages - 3)
                        <span class="pagination-btn" style="border:none;cursor:default;">...</span>
                    @endif
                @endfor
                <button class="pagination-btn" {{ $currentPage >= $totalPages ? 'disabled' : '' }}
                        onclick="window.location.href='{{ route('tags.index') }}?page={{ $currentPage + 1 }}&sort={{ $sortBy }}{{ request('search') ? '&search=' . request('search') : '' }}'">
                    ›
                </button>
            </div>
        @endif

    @else
        <div class="tags-empty">
            <svg class="tags-empty-icon" style="width:64px;height:64px;margin:0 auto 16px;color:#d6d9dc;"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <h2 class="tags-empty-title">Aucun tag trouvé</h2>
            <p class="tags-empty-text">
                @if(request('search'))
                    Aucun tag ne correspond à "{{ request('search') }}".
                @else
                    Il n'y a pas encore de tags dans la communauté.
                @endif
            </p>
        </div>
    @endif

</div>

<script>
// Recherche en temps réel côté client
let searchTimeout = null;
function filterTagsLive(value) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const query = value.toLowerCase().trim();
        const cards = document.querySelectorAll('#tags-grid .tag-card');
        cards.forEach(card => {
            const name = card.dataset.name || '';
            card.style.display = (!query || name.includes(query)) ? '' : 'none';
        });
    }, 200);
}
</script>

</x-app-layout>
