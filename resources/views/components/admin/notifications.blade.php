@props(['notifications'])

<div class="dropdown">
    <button class="btn btn-link position-relative" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        @if($notifications->where('is_read', false)->count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $notifications->where('is_read', false)->count() }}
            </span>
        @endif
    </button>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="width: 300px;">
        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
            <h6 class="mb-0">Notifications</h6>
            @if($notifications->where('is_read', false)->count() > 0)
                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link btn-sm text-decoration-none">Tout marquer comme lu</button>
                </form>
            @endif
        </div>
        <div class="notifications-list" style="max-height: 400px; overflow-y: auto;">
            @forelse($notifications as $notification)
                <a href="{{ $notification->link }}" class="dropdown-item py-2 {{ $notification->is_read ? '' : 'bg-light' }}">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            @switch($notification->type)
                                @case('new_order')
                                    <i class="bi bi-cart text-primary"></i>
                                    @break
                                @case('order_status')
                                    <i class="bi bi-truck text-info"></i>
                                    @break
                                @case('payment_status')
                                    <i class="bi bi-credit-card text-success"></i>
                                    @break
                                @default
                                    <i class="bi bi-bell text-secondary"></i>
                            @endswitch
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                            <div class="fw-bold">{{ $notification->title }}</div>
                            <div class="small">{{ $notification->message }}</div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="dropdown-item text-center py-3">
                    <i class="bi bi-bell-slash text-muted"></i>
                    <p class="mb-0 text-muted">Aucune notification</p>
                </div>
            @endforelse
        </div>
    </div>
</div> 