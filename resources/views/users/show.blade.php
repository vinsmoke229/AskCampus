<x-app-layout>
@php
    $ac=['#5046e5','#7c3aed','#059669','#dc2626','#d97706','#0891b2','#c026d3','#0284c7'];
    $ci=abs(crc32($user->name))%count($ac);
@endphp

<div style="background:linear-gradient(135deg,#5046e5,#7c3aed);border-radius:16px;padding:32px;
            color:#fff;margin-bottom:24px;position:relative;overflow:hidden;
            display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
    
    {{-- Avatar géant --}}
    <div style="width:96px;height:96px;border-radius:24px;background:rgba(255,255,255,.2);backdrop-filter:blur(4px);
                border:3px solid rgba(255,255,255,.3);display:flex;align-items:center;justify-content:center;
                font-size:42px;font-weight:900;flex-shrink:0;">
        {{ strtoupper(substr($user->name,0,1)) }}
    </div>

    {{-- Info --}}
    <div style="flex:1;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
            <h1 style="font-size:28px;font-weight:800;margin:0;">{{ $user->name }}</h1>
            @if($user->is_moderator)
                <span style="font-size:11px;font-weight:800;background:#fefce8;color:#92400e;
                             padding:3px 8px;border-radius:20px;">MODÉRATEUR</span>
            @endif
        </div>
        <div style="font-size:14px;color:rgba(255,255,255,.8);margin-bottom:12px;">
            Membre depuis {{ $user->created_at->isoFormat('MMMM YYYY') }}
        </div>
        <div style="display:flex;align-items:baseline;gap:8px;">
            <span style="font-size:32px;font-weight:900;line-height:1;">{{ number_format($user->reputation) }}</span>
            <span style="font-size:14px;color:rgba(255,255,255,.8);">points de réputation</span>
        </div>
    </div>
</div>

<div style="display:flex;gap:24px;flex-wrap:wrap;align-items:flex-start;">
    
    {{-- Sidebar (Stats) --}}
    <div style="width:260px;flex-shrink:0;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
            <h3 style="font-size:14px;font-weight:700;color:#111827;margin:0 0 16px;">Statistiques</h3>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                <span style="font-size:13px;color:#6b7280;">Questions posées</span>
                <span style="font-size:14px;font-weight:700;color:#111827;">{{ $stats['questions_count'] }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                <span style="font-size:13px;color:#6b7280;">Réponses données</span>
                <span style="font-size:14px;font-weight:700;color:#111827;">{{ $stats['answers_count'] }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;">
                <span style="font-size:13px;color:#6b7280;">Réponses acceptées</span>
                <span style="font-size:14px;font-weight:700;color:#059669;">{{ $stats['accepted_answers'] }}</span>
            </div>
        </div>
    </div>

    {{-- Historique (Tabs) --}}
    <div style="flex:1;min-width:0;" x-data="{ tab: 'questions' }">
        <div style="display:flex;gap:12px;margin-bottom:16px;">
            <button @click="tab = 'questions'"
                    :style="tab === 'questions' ? 'background:#111827;color:#fff' : 'background:#f3f4f6;color:#4b5563'"
                    style="padding:8px 16px;border-radius:20px;font-size:13px;font-weight:700;border:none;cursor:pointer;">
                Questions ({{ $stats['questions_count'] }})
            </button>
            <button @click="tab = 'answers'"
                    :style="tab === 'answers' ? 'background:#111827;color:#fff' : 'background:#f3f4f6;color:#4b5563'"
                    style="padding:8px 16px;border-radius:20px;font-size:13px;font-weight:700;border:none;cursor:pointer;">
                Réponses ({{ $stats['answers_count'] }})
            </button>
        </div>

        {{-- Section Questions --}}
        <div x-show="tab === 'questions'">
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                @forelse($questions as $q)
                    <div style="padding:16px;border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                            <span style="font-size:12px;font-weight:700;color:{{ $q->vote_score >= 0 ? '#5046e5' : '#dc2626' }};">
                                {{ $q->vote_score }} votes
                            </span>
                            @if($q->is_solved)
                                <span style="font-size:11px;font-weight:700;background:#dcfce7;color:#16a34a;padding:2px 8px;border-radius:4px;">Résolue</span>
                            @endif
                        </div>
                        <a href="{{ route('questions.show', $q) }}"
                           style="display:block;font-size:15px;font-weight:600;color:#1d4ed8;margin-bottom:4px;text-decoration:none;"
                           onmouseover="this.style.color='#1e40af'" onmouseout="this.style.color='#1d4ed8'">
                            {{ $q->title }}
                        </a>
                        <div style="font-size:12px;color:#9ca3af;">{{ $q->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div style="padding:32px 16px;text-align:center;color:#6b7280;font-size:14px;">Aucune question posée.</div>
                @endforelse
            </div>
            <div style="margin-top:16px;">{{ $questions->appends(['answers_page' => request('answers_page')])->links() }}</div>
        </div>

        {{-- Section Réponses --}}
        <div x-show="tab === 'answers'" x-cloak>
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                @forelse($answers as $a)
                    <div style="padding:16px;border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                            <span style="font-size:12px;font-weight:700;color:{{ $a->vote_score >= 0 ? '#5046e5' : '#dc2626' }};">
                                {{ $a->vote_score ?? $a->votes()->sum('value') }} votes
                            </span>
                            @if($a->is_accepted)
                                <span style="font-size:11px;font-weight:700;background:#dcfce7;color:#16a34a;padding:2px 8px;border-radius:4px;">✓ Acceptée</span>
                            @endif
                        </div>
                        <div style="font-size:13px;color:#374151;margin-bottom:8px;line-height:1.5;">
                            {{ Str::limit(strip_tags($a->body), 150) }}
                        </div>
                        <div style="font-size:12px;color:#9ca3af;">
                            A répondu à : 
                            <a href="{{ route('questions.show', $a->question) }}" style="color:#1d4ed8;text-decoration:none;">{{ $a->question->title }}</a>
                            • {{ $a->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div style="padding:32px 16px;text-align:center;color:#6b7280;font-size:14px;">Aucune réponse donnée.</div>
                @endforelse
            </div>
            <div style="margin-top:16px;">{{ $answers->appends(['questions_page' => request('questions_page')])->links() }}</div>
        </div>
    </div>
</div>
</x-app-layout>
