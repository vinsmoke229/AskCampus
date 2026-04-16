<x-app-layout>

{{-- ══════════════════════════════════════════
     TAGS PAGE - Stack Overflow Style
══════════════════════════════════════════ --}}

<style>
    /* Container */
    .tags-container { max-width: 1264px; margin: 0 auto; }
    
    /* Header */
    .tags-header { margin-bottom: 16px; }
    .tags-title { font-size: 27px; font-weight: 400; color: #232629; margin: 0 0 12px; }
    .tags-description { font-size: 15px; color: #3b4045; line-height: 1.5; margin-bottom: 8px; }
    .tags-link { font-size: 13px; color: #0074cc; }
    .tags-link:hover { color: #0a95ff; }
    
    /* Search & Filter Bar */
    .tags-controls { 
        display: flex; gap: 12px; align-items: center; justify-content: space-between;
        margin-bottom: 16px; flex-wrap: wrap;
    }
    .tags-search { 
        flex: 1; min-width: 200px; max-width: 300px;
        position: relative;
    }
    .tags-search-icon { 
        position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; color: #6a737c; pointer-events: none;
    }
    .tags-search-input { 
        width: 100%; padding: 8px 12px 8px 36px; font-size: 13px;
        border: 1px solid #babfc4; border-radius: 3px;
        color: #232629; outline: none;
    }
    .tags-search-input:focus { border-color: #6cbbf7; box-shadow: 0 0 0 4px rgba(0,149,255,0.15); }
    
    .tags-filters { display: flex; gap: 4px; }
    .tags-filter-btn { 
        padding: 8px 12px; font-size: 13px; font-weight: 400;
        background: #fff; color: #6a737c; border: 1px solid #babfc4;
        border-radius: 3px; cursor: pointer; transition: all 0.1s;
    }
    .tags-filter-btn:hover { background: #f8f9f9; }
    .tags-filter-btn.active { 
        background: #e3e6e8; color: #232629; font-weight: 700;
        border-color: #9fa6ad;
    }
    
    /* Tags Grid */
    .tags-grid { 
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 12px;
    }
    
    @media (max-width: 1024px) {
        .tags-grid { grid-template-columns: repeat(3, 1fr); }
    }
    
    @media (max-width: 768px) {
        .tags-grid { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 480px) {
        .tags-grid { grid-template-columns: 1fr; }
    }
    
    /* Tag Card */
    .tag-card { 
        background: #fff; border: 1px solid #e3e6e8; border-radius: 3px;
        padding: 12px; transition: box-shadow 0.1s;
    }
    .tag-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    
    .tag-name { 
        display: inline-block; padding: 4px 6px; font-size: 12px;
        background: #e1ecf4; color: #39739d; border-radius: 3px;
        text-decoration: none; margin-bottom: 8px; font-weight: 400;
    }
    .tag-name:hover { background: #d0e3f1; }
    
    .tag-description { 
        font-size: 13px; color: #3b4045; line-height: 1.5;
        margin-bottom: 12px; display: -webkit-box;
        -webkit-line-clamp: 3; -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .tag-stats { 
        display: flex; justify-content: space-between; align-items: center;
        font-size: 12px; color: #6a737c;
    }
    .tag-questions { font-weight: 700; color: #232629; }
    .tag-activity { }
    
    /* Pagination */
    .tags-pagination { 
        display: flex; justify-content: center; align-items: center;
        gap: 4px; margin-top: 24px;
    }
    .pagination-btn { 
        padding: 6px 10px; font-size: 13px;
        background: #fff; color: #6a737c; border: 1px solid #babfc4;
        border-radius: 3px; cursor: pointer; transition: all 0.1s;
        min-width: 32px; text-align: center;
    }
    .pagination-btn:hover { background: #f8f9f9; }
    .pagination-btn.active { 
        background: #f48225; color: #fff; border-color: #f48225;
        font-weight: 700;
    }
    .pagination-btn:disabled { 
        opacity: 0.5; cursor: not-allowed;
    }
    
    /* Empty State */
    .tags-empty { 
        text-align: center; padding: 64px 24px;
        background: #f8f9f9; border: 1px solid #e3e6e8; border-radius: 3px;
    }
    .tags-empty-icon { 
        width: 64px; height: 64px; margin: 0 auto 16px;
        color: #d6d9dc;
    }
    .tags-empty-title { font-size: 21px; font-weight: 400; color: #232629; margin-bottom: 8px; }
    .tags-empty-text { font-size: 15px; color: #6a737c; }
</style>

@php
    // Récupérer tous les tags avec le nombre de questions
    $allTags = \App\Models\Tag::withCount('questions')
        ->orderByDesc('questions_count')
        ->get();
    
    // Filtrer par recherche si présent
    if (request('search')) {
        $search = strtolower(request('search'));
        $allTags = $allTags->filter(function($tag) use ($search) {
            return str_contains(strtolower($tag->name), $search) || 
                   str_contains(strtolower($tag->description ?? ''), $search);
        });
    }
    
    // Trier selon le filtre
    $sortBy = request('sort', 'popular');
    if ($sortBy === 'name') {
        $allTags = $allTags->sortBy('name');
    } elseif ($sortBy === 'new') {
        $allTags = $allTags->sortByDesc('created_at');
    }
    
    // Pagination manuelle
    $perPage = 36;
    $currentPage = request('page', 1);
    $totalTags = $allTags->count();
    $totalPages = ceil($totalTags / $perPage);
    $offset = ($currentPage - 1) * $perPage;
    $tags = $allTags->slice($offset, $perPage);
@endphp

<div class="tags-container">
    
    {{-- ══════════ HEADER ══════════ --}}
    <div class="tags-header">
        <h1 class="tags-title">Tags</h1>
        <p class="tags-description">
            Un tag est un mot-clé ou une étiquette qui catégorise votre question avec d'autres questions similaires. 
            L'utilisation des bons tags facilite la recherche et la réponse à votre question par d'autres utilisateurs.
        </p>
        <a href="#" class="tags-link">Afficher tous les synonymes de tags</a>
    </div>
    
    {{-- ══════════ SEARCH & FILTERS ══════════ --}}
    <div class="tags-controls">
        <div class="tags-search">
            <svg class="tags-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" 
                   class="tags-search-input" 
                   placeholder="Filtrer par nom de tag"
                   value="{{ request('search') }}"
                   onchange="window.location.href='{{ route('tags.index') }}?search=' + this.value + '&sort={{ $sortBy }}'">
        </div>
        
        <div class="tags-filters">
            <button class="tags-filter-btn {{ $sortBy === 'popular' ? 'active' : '' }}"
                    onclick="window.location.href='{{ route('tags.index') }}?sort=popular{{ request('search') ? '&search=' . request('search') : '' }}'">
                Populaire
            </button>
            <button class="tags-filter-btn {{ $sortBy === 'name' ? 'active' : '' }}"
                    onclick="window.location.href='{{ route('tags.index') }}?sort=name{{ request('search') ? '&search=' . request('search') : '' }}'">
                Nom
            </button>
            <button class="tags-filter-btn {{ $sortBy === 'new' ? 'active' : '' }}"
                    onclick="window.location.href='{{ route('tags.index') }}?sort=new{{ request('search') ? '&search=' . request('search') : '' }}'">
                Nouveau
            </button>
        </div>
    </div>
    
    {{-- ══════════ TAGS GRID ══════════ --}}
    @if($tags->count() > 0)
        <div class="tags-grid">
            @foreach($tags as $tag)
                @php
                    // Calculer l'activité récente (questions posées cette semaine)
                    $recentQuestions = $tag->questions()
                        ->where('created_at', '>=', now()->subWeek())
                        ->count();
                    
                    // Texte d'activité
                    if ($recentQuestions > 0) {
                        $activityText = $recentQuestions . ' posée' . ($recentQuestions > 1 ? 's' : '') . ' cette semaine';
                    } else {
                        $lastQuestion = $tag->questions()->latest()->first();
                        if ($lastQuestion) {
                            $activityText = 'Posée ' . $lastQuestion->created_at->diffForHumans();
                        } else {
                            $activityText = 'Aucune question';
                        }
                    }
                @endphp
                
                <div class="tag-card">
                    <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}" class="tag-name">
                        {{ $tag->name }}
                    </a>
                    
                    <p class="tag-description">
                        {{ $tag->description ?? 'Pour les questions relatives à ' . $tag->name . '.' }}
                    </p>
                    
                    <div class="tag-stats">
                        <span class="tag-questions">
                            {{ number_format($tag->questions_count) }} 
                            question{{ $tag->questions_count > 1 ? 's' : '' }}
                        </span>
                        <span class="tag-activity">{{ $activityText }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- ══════════ PAGINATION ══════════ --}}
        @if($totalPages > 1)
            <div class="tags-pagination">
                {{-- Previous --}}
                <button class="pagination-btn" 
                        {{ $currentPage <= 1 ? 'disabled' : '' }}
                        onclick="window.location.href='{{ route('tags.index') }}?page={{ $currentPage - 1 }}&sort={{ $sortBy }}{{ request('search') ? '&search=' . request('search') : '' }}'">
                    ‹
                </button>
                
                {{-- Page Numbers --}}
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
                
                {{-- Next --}}
                <button class="pagination-btn" 
                        {{ $currentPage >= $totalPages ? 'disabled' : '' }}
                        onclick="window.location.href='{{ route('tags.index') }}?page={{ $currentPage + 1 }}&sort={{ $sortBy }}{{ request('search') ? '&search=' . request('search') : '' }}'">
                    ›
                </button>
            </div>
        @endif
        
    @else
        {{-- Empty State --}}
        <div class="tags-empty">
            <svg class="tags-empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <h2 class="tags-empty-title">Aucun tag trouvé</h2>
            <p class="tags-empty-text">
                @if(request('search'))
                    Aucun tag ne correspond à votre recherche "{{ request('search') }}".
                @else
                    Il n'y a pas encore de tags dans la communauté.
                @endif
            </p>
        </div>
    @endif
    
</div>

</x-app-layout>
