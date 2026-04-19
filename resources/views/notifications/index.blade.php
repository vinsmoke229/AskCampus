<x-app-layout>

<style>
    .notif-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px;
    }
    .notif-title { font-size: 27px; font-weight: 400; color: #232629; margin: 0; }
    .notif-mark-all {
        padding: 7px 12px; font-size: 13px; color: #0074cc;
        border: 1px solid #0074cc; border-radius: 3px; background: #fff;
        cursor: pointer; text-decoration: none; transition: all .1s;
    }
    .notif-mark-all:hover { background: #e1ecf4; }

    .notif-list { border: 1px solid #e3e6e8; border-radius: 3px; overflow: hidden; }
    .notif-item {
        display: flex; gap: 12px; align-items: flex-start;
        padding: 14px 16px; border-bottom: 1px solid #e3e6e8;
        transition: background .1s; text-decoration: none; color: inherit;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: #f8f9f9; }
    .notif-item.unread { background: #fdf7e3; }
    .notif-item.unread:hover { background: #fef3c7; }

    .notif-icon {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 16px;
    }
    .notif-icon.accepted { background: #d1fae5; }
    .notif-icon.vote-up  { background: #dbeafe; }
    .notif-icon.vote-down { background: #fee2e2; }
    .notif-icon.answer   { background: #ede9fe; }

    .notif-body { flex: 1; min-width: 0; }
    .notif-message { font-size: 14px; color: #232629; margin-bottom: 4px; }
    .notif-question {
        font-size: 13px; color: #0074cc; white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
    }
    .notif-time { font-size: 12px; color: #9fa6ad; margin-top: 4px; }

    .notif-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #f48225; flex-shrink: 0; margin-top: 6px;
    }

    .notif-empty {
        text-align: center; padding: 64px 24px;
        color: #6a737c;
    }
    .notif-empty-title { font-size: 21px; font-weight: 400; color: #232629; margin-bottom: 8px; }

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
    <div class="notif-header">
        <h1 class="notif-title">Notifications</h1>
        @if($notifications->count() > 0)
            <form method="POST" action="{{ route('notifications.readAll') }}">
                @csrf
                <button type="submit" class="notif-mark-all">
                    Tout marquer comme lu
                </button>
            </form>
        @endif
    </div>

    @if($notifications->count() > 0)
        <div class="notif-list">
            @foreach($notifications as $notif)
                @php
                    $data    = $notif->data;
                    $type    = $data['type'] ?? '';
                    $isUnread = is_null($notif->read_at);
                    $url     = $data['url'] ?? '#';
                @endphp

                <a href="{{ route('notifications.read', $notif->id) }}"
                   class="notif-item {{ $isUnread ? 'unread' : '' }}">

                    {{-- Icône selon le type --}}
                    <div class="notif-icon
                        @if($type === 'answer_accepted') accepted
                        @elseif($type === 'vote_received' && ($data['value'] ?? 0) > 0) vote-up
                        @elseif($type === 'vote_received') vote-down
                        @else answer
                        @endif">
                        @if($type === 'answer_accepted')
                            ✅
                        @elseif($type === 'vote_received' && ($data['value'] ?? 0) > 0)
                            👍
                        @elseif($type === 'vote_received')
                            👎
                        @else
                            💬
                        @endif
                    </div>

                    <div class="notif-body">
                        <div class="notif-message">{{ $data['message'] ?? '' }}</div>
                        @if(!empty($data['question_title']))
                            <div class="notif-question">{{ $data['question_title'] }}</div>
                        @elseif(!empty($data['votable_title']))
                            <div class="notif-question">{{ $data['votable_title'] }}</div>
                        @endif
                        <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>

                    @if($isUnread)
                        <div class="notif-dot"></div>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="so-pagination">
                @if($notifications->onFirstPage())
                    <span class="so-page-btn disabled">‹ Préc</span>
                @else
                    <a href="{{ $notifications->previousPageUrl() }}" class="so-page-btn">‹ Préc</a>
                @endif
                @foreach($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                    @if($page == $notifications->currentPage())
                        <span class="so-page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="so-page-btn">{{ $page }}</a>
                    @endif
                @endforeach
                @if($notifications->hasMorePages())
                    <a href="{{ $notifications->nextPageUrl() }}" class="so-page-btn">Suiv ›</a>
                @else
                    <span class="so-page-btn disabled">Suiv ›</span>
                @endif
            </div>
        @endif

    @else
        <div class="notif-empty">
            <div style="font-size:48px;margin-bottom:12px;">🔔</div>
            <h2 class="notif-empty-title">Aucune notification</h2>
            <p>Vous n'avez pas encore de notifications. Elles apparaîtront ici quand quelqu'un interagit avec votre contenu.</p>
        </div>
    @endif
</div>

</x-app-layout>
