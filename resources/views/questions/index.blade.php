<x-app-layout>

{{-- ══════════ HEADER ══════════ --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <h1 style="font-size:26px;font-weight:800;color:#111827;margin:0;letter-spacing:-.3px;">
        Questions récemment actives
    </h1>
    <a href="{{ route('questions.create') }}"
       style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;
              font-size:13px;font-weight:700;color:#fff;border-radius:10px;text-decoration:none;
              background:linear-gradient(135deg,#5046e5,#7c3aed);
              box-shadow:0 4px 12px rgba(80,70,229,.3);white-space:nowrap;"
       onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Poser une question
    </a>
</div>

<div x-data="{ showFilters: false }" style="margin-bottom: 20px;">
    {{-- ══════════ FILTER BAR ══════════ --}}
    <div style="display:flex;align-items:center;justify-content:space-between;
                padding-bottom:14px;border-bottom:2px solid #f3f4f6;">

        <span style="font-size:13px;color:#9ca3af;font-weight:500;">
            {{ number_format($questions->total()) }} question{{ $questions->total() > 1 ? 's' : '' }}
        </span>

        <div style="display:flex;align-items:center;gap:8px;">

            {{-- Grouped sort tabs --}}
            @php
                if (!request('filter') && !request('sort'))       $tab = 'recent';
                elseif (request('sort') === 'active')             $tab = 'active';
                elseif (request('filter') === 'unsolved')         $tab = 'unsolved';
                elseif (request('filter') === 'solved')           $tab = 'solved';
                else                                              $tab = 'recent';
            @endphp

            <div style="display:flex;border:1.5px solid #e5e7eb;border-radius:10px;overflow:hidden;font-size:13px;">
                @php
                    $tabs = [
                        'recent'  => ['label'=>'Récentes',     'url'=> route('questions.index')],
                        'active'  => ['label'=>'Actives',      'url'=> route('questions.index', ['sort'=>'active'])],
                        'unsolved'=> ['label'=>'Sans réponse', 'url'=> route('questions.index', ['filter'=>'unsolved'])],
                        'solved'  => ['label'=>'Résolues',     'url'=> route('questions.index', ['filter'=>'solved'])],
                    ];
                @endphp
                @foreach($tabs as $key => $t)
                    @php $active = ($tab === $key); @endphp
                    <a href="{{ $t['url'] }}"
                       style="display:block;padding:8px 14px;text-decoration:none;
                              {{ !$loop->first ? 'border-left:1.5px solid #e5e7eb;' : '' }}
                              background:{{ $active ? 'linear-gradient(135deg,#5046e5,#7c3aed)' : '#fff' }};
                              color:{{ $active ? '#fff' : '#6b7280' }};
                              font-weight:{{ $active ? '700' : '400' }};
                              transition:background .12s,color .12s;"
                       onmouseover="if({{ $active ? 'false' : 'true' }}){ this.style.background='#f5f5fd'; this.style.color='#5046e5'; }"
                       onmouseout="if({{ $active ? 'false' : 'true' }}){ this.style.background='#fff'; this.style.color='#6b7280'; }">
                        {{ $t['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Filter button --}}
            <button @click="showFilters = !showFilters"
                    :style="showFilters ? 'background:#eef2ff; border-color:#a5b4fc; color:#5046e5;' : 'background:#fff; border-color:#e5e7eb; color:#6b7280;'"
                    style="display:inline-flex;align-items:center;gap:5px;padding:8px 14px;
                           font-size:13px;font-weight:500;
                           border:1.5px solid;border-radius:10px;
                           cursor:pointer;transition:all .12s;"
                    onmouseover="if(!showFilters){this.style.borderColor='#a5b4fc';this.style.color='#5046e5';this.style.background='#f5f5fd';}"
                    onmouseout="if(!showFilters){this.style.borderColor='#e5e7eb';this.style.color='#6b7280';this.style.background='#fff';}">
                <svg style="width:13px;height:13px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filtrer
            </button>
        </div>
    </div>

    {{-- Advanced Filter Dropdown --}}
    <div x-show="showFilters" style="display:none;" x-transition>
        <div style="background:#f9fafb; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px; padding: 20px;">
            <form action="{{ route('questions.index') }}" method="GET" style="margin: 0;">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 20px;">
                    
                    {{-- Filter By --}}
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #374151; margin-bottom: 12px; margin-top: 0;">Filtrer par</h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4b5563; cursor: pointer;">
                                <input type="radio" name="filter" value="" {{ request('filter') ? '' : 'checked' }} style="accent-color: #5046e5;">
                                Toutes les questions
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4b5563; cursor: pointer;">
                                <input type="radio" name="filter" value="unsolved" {{ request('filter') === 'unsolved' ? 'checked' : '' }} style="accent-color: #5046e5;">
                                Sans réponse
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4b5563; cursor: pointer;">
                                <input type="radio" name="filter" value="solved" {{ request('filter') === 'solved' ? 'checked' : '' }} style="accent-color: #5046e5;">
                                Résolues
                            </label>
                        </div>
                    </div>

                    {{-- Sort By --}}
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #374151; margin-bottom: 12px; margin-top: 0;">Trier par</h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4b5563; cursor: pointer;">
                                <input type="radio" name="sort" value="latest" {{ request('sort') !== 'active' ? 'checked' : '' }} style="accent-color: #5046e5;">
                                Plus récentes
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4b5563; cursor: pointer;">
                                <input type="radio" name="sort" value="active" {{ request('sort') === 'active' ? 'checked' : '' }} style="accent-color: #5046e5;">
                                Récemment actives
                            </label>
                        </div>
                    </div>

                    {{-- Tag --}}
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #374151; margin-bottom: 12px; margin-top: 0;">Tagué avec</h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 13px; color: #4b5563; margin-bottom: 2px;">
                                Le tag suivant :
                            </label>
                            <input type="text" name="tag" value="{{ request('tag') }}" placeholder="Ex: laravel, php, javascript" 
                                   style="padding: 8px 12px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; width: 100%; max-width: 250px;">
                        </div>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #e5e7eb; padding-top: 16px;">
                    <button type="submit" style="padding: 8px 16px; background: linear-gradient(135deg, #5046e5, #7c3aed); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; box-shadow: 0 2px 4px rgba(80,70,229,.2);">
                        Appliquer le filtre
                    </button>
                    <button type="button" @click="showFilters = false" style="padding: 8px 16px; background: transparent; color: #6b7280; font-size: 13px; font-weight: 500; border: none; cursor: pointer;">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════ QUESTION LIST ══════════ --}}
<div>
    @forelse($questions as $question)
        @php
            $answerCount = $question->answers->count();
            $palette     = ['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2','#c026d3','#0284c7'];
            $isAnonAdmin = ($question->user->name ?? '') === 'admin';
            $displayName = $isAnonAdmin ? 'Anonyme' : ($question->user->name ?? 'Utilisateur inconnu');
            $avatarBg    = $palette[abs(crc32($displayName)) % count($palette)];
            $views       = $question->views;
            $viewsStr    = $views >= 1000000
                            ? number_format($views/1000000,1).'M vues'
                            : ($views >= 1000 ? number_format($views/1000,1).'k vues' : $views.' vues');
        @endphp

        <article style="display:flex;gap:16px;padding:16px 12px;border-bottom:1px solid #f3f4f6;
                        background:#fff;transition:background .08s;"
                 onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">

            {{-- ── Stats Column ── --}}
            <div style="width:108px;flex-shrink:0;display:flex;flex-direction:column;
                        align-items:flex-end;gap:7px;">

                {{-- Votes --}}
                <div style="font-size:13px;color:#9ca3af;white-space:nowrap;text-align:right;">
                    @if($question->vote_score > 0)
                        <span style="font-weight:700;color:#5046e5;">+{{ $question->vote_score }}</span>
                    @elseif($question->vote_score < 0)
                        <span style="font-weight:700;color:#dc2626;">{{ $question->vote_score }}</span>
                    @else
                        <span style="color:#9ca3af;">0</span>
                    @endif
                    {{ abs($question->vote_score) === 1 ? 'vote' : 'votes' }}
                </div>

                {{-- Answer badge --}}
                @if($question->is_solved)
                    <div style="display:inline-flex;align-items:center;justify-content:center;
                                padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;
                                background:#059669;color:#fff;white-space:nowrap;">
                        ✓ {{ $answerCount }} rép.
                    </div>
                @elseif($answerCount > 0)
                    <div style="display:inline-flex;align-items:center;justify-content:center;
                                padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;
                                border:1.5px solid #059669;color:#059669;white-space:nowrap;">
                        {{ $answerCount }} {{ $answerCount > 1 ? 'rép.' : 'rép.' }}
                    </div>
                @else
                    <div style="display:inline-flex;align-items:center;justify-content:center;
                                padding:4px 10px;border-radius:20px;font-size:12px;
                                border:1.5px solid #e5e7eb;color:#d1d5db;white-space:nowrap;">
                        0 rép.
                    </div>
                @endif

                {{-- Views --}}
                <div style="font-size:12px;white-space:nowrap;
                            color:{{ $views >= 1000 ? '#d97706' : '#d1d5db' }};
                            font-weight:{{ $views >= 1000 ? '600' : '400' }};">
                    {{ $viewsStr }}
                </div>
            </div>

            {{-- ── Content Column ── --}}
            <div style="flex:1;min-width:0;">

                {{-- Title --}}
                <h2 style="margin:0 0 5px;padding:0;font-size:17px;font-weight:600;line-height:1.3;">
                    <a href="{{ route('questions.show', $question) }}"
                       style="color:#1d4ed8;text-decoration:none;"
                       onmouseover="this.style.color='#5046e5'" onmouseout="this.style.color='#1d4ed8'">
                        {{ $question->title }}
                    </a>
                </h2>

                {{-- Excerpt --}}
                <p style="font-size:13px;color:#6b7280;margin:0 0 10px;
                           display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
                           overflow:hidden;line-height:1.5;">
                    {{ Str::limit(strip_tags($question->body), 220) }}
                </p>

                {{-- Tags + User meta --}}
                <div style="display:flex;align-items:center;justify-content:space-between;
                            gap:8px;flex-wrap:wrap;">

                    {{-- Tags --}}
                    <div style="display:flex;flex-wrap:wrap;gap:5px;">
                        @foreach($question->tags as $tag)
                            <a href="{{ route('questions.index', ['tag' => $tag->slug]) }}"
                               style="display:inline-flex;align-items:center;padding:3px 10px;
                                      font-size:12px;font-weight:600;color:#5046e5;background:#eef2ff;
                                      border-radius:20px;text-decoration:none;border:1px solid #c7d2fe;
                                      transition:all .12s;"
                               onmouseover="this.style.background='#e0e7ff';this.style.borderColor='#a5b4fc';"
                               onmouseout="this.style.background='#eef2ff';this.style.borderColor='#c7d2fe';">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>

                    {{-- User meta --}}
                    <div style="display:flex;align-items:center;gap:5px;font-size:12px;
                                flex-shrink:0;margin-left:auto;">
                        {{-- Avatar --}}
                        <div style="width:18px;height:18px;border-radius:4px;background:{{ $avatarBg }};
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="color:#fff;font-weight:800;font-size:9px;line-height:1;">
                                {{ strtoupper(substr($displayName, 0, 1)) }}
                            </span>
                        </div>
                        {{-- Name --}}
                        <a href="#" style="color:#5046e5;text-decoration:none;font-weight:600;"
                           onmouseover="this.style.color='#4338ca'" onmouseout="this.style.color='#5046e5'">
                            {{ $displayName }}
                        </a>
                        {{-- Reputation --}}
                        @if(!$isAnonAdmin && ($question->user->reputation ?? 0) > 0)
                            <span style="color:#7c3aed;font-weight:700;">
                                {{ number_format($question->user->reputation) }}
                            </span>
                        @endif
                        {{-- Time --}}
                        <span style="color:#9ca3af;">posé {{ $question->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </article>

    @empty
        {{-- Empty state --}}
        <div style="padding:64px 0;text-align:center;">
            <div style="width:72px;height:72px;border-radius:20px;
                        background:linear-gradient(135deg,#eef2ff,#f5f3ff);
                        display:flex;align-items:center;justify-content:center;
                        margin:0 auto 16px;">
                <svg style="width:36px;height:36px;color:#a5b4fc;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 style="font-size:18px;font-weight:700;color:#111827;margin:0 0 8px;">
                Aucune question trouvée
            </h3>
            <p style="font-size:14px;color:#9ca3af;margin:0 auto 24px;max-width:340px;">
                @if(request('search'))
                    Aucun résultat pour « {{ request('search') }} ». Essayez d'autres mots-clés.
                @else
                    Soyez le premier à poser une question à la communauté !
                @endif
            </p>
            <a href="{{ route('questions.create') }}"
               style="display:inline-flex;align-items:center;gap:6px;padding:11px 20px;
                      font-size:14px;font-weight:700;color:#fff;border-radius:10px;text-decoration:none;
                      background:linear-gradient(135deg,#5046e5,#7c3aed);
                      box-shadow:0 4px 14px rgba(80,70,229,.35);"
               onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Poser la première question
            </a>
        </div>
    @endforelse
</div>

{{-- ══════════ PAGINATION ══════════ --}}
@if($questions->hasPages())
    <div style="margin-top:20px;padding:0 12px;">
        {{ $questions->links() }}
    </div>
@endif

</x-app-layout>
