<aside id="sidebar" class="parent-sidebar">
    <!-- Header -->
    <div class="sidebar-header text-center">
        <h5 class="fw-bold mb-1">🎓 Espace Parent</h5>
        <small class="text-muted">
            
        </small>
    </div>

    <!-- Menu -->
    <ul class="nav flex-column px-2">

        <li class="nav-item">
            <a class="nav-link"
               href="">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-journal-text"></i>
                <span>Bulletins</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-bar-chart"></i>
                <span>Résultats</span>
            </a>
        </li>

     <li class="nav-item dropdown">
    <a class="nav-link position-relative" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
        <i class="bi bi-envelope"></i>
        <span>Messages</span>
        {{-- @php
            $unreadCount = auth('parent')->user()->unreadNotifications->count();
        @endphp
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadCount }}
            </span>
        @endif --}}
    </a>

<ul class="dropdown-menu dropdown-menu-end notification-dropdown shadow-lg"
    aria-labelledby="messagesDropdown">

    {{-- Header --}}
    <li class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2">
        <span class="fw-bold text-gradient">
            <i class="bi bi-bell-fill me-1"></i> Notifications
        </span>

        {{-- <span class="badge bg-primary rounded-pill">
            {{ auth('parent')->user()->unreadNotifications()->count() }}
        </span> --}}
    </li>

    <li><hr class="dropdown-divider my-1"></li>

    {{-- Notifications --}}
    {{-- @forelse(auth('parent')->user()->notifications()->latest()->take(8)->get() as $notification)
        <li>
            <a class="dropdown-item notification-item
                {{ is_null($notification->read_at) ? 'unread' : '' }}"
               href="{{ $notification->data['url'] ?? route('parent.messages.show', $notification->id) }}"
               onclick="markAsRead({{ $notification->id }})">

                {{-- Dot --}}
                {{-- @if(is_null($notification->read_at))
                    <span class="notif-dot"></span>
                @endif --}}

                {{-- <div class="pe-3">
                    <div class="fw-semibold small">
                        {{ $notification->data['title'] ?? 'Notification' }}
                    </div>

                    <div class="text-muted small mt-1">
                        {{ Str::limit($notification->data['message'] ?? 'Nouvelle notification reçue.', 55) }}
                    </div>

                    <div class="text-muted x-small mt-1">
                        <i class="bi bi-clock me-1"></i>
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
            </a>
        </li>
    @empty
        <li class="dropdown-item text-center text-muted py-4">
            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
            Aucune notification
        </li>
    @endforelse  --}}

    <li><hr class="dropdown-divider my-1"></li>

    {{-- Footer --}}
    <li>
        <a class="dropdown-item text-center fw-semibold see-all"
           href="">
            Voir toutes les notifications
            <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </li>
</ul>
</li>


        <!-- Divider -->
        <li class="my-3 px-3">
            <hr>
        </li>

        <!-- Logout -->
        <li class="nav-item px-1">
            <form method="POST" action=" }}">
                @csrf
                <button class="nav-link text-danger w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </li>

    </ul>
</aside>

<style>
/* Sidebar base */
.parent-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 260px;
    height: 100vh;
    background: linear-gradient(180deg, #0d6efd, #0b5ed7);
    padding-top: 1rem;
    transition: all 0.3s ease;
    z-index: 1040;
}

/* Header */
.sidebar-header {
    padding: 1rem;
    color: #fff;
}

/* Nav links */
.parent-sidebar .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    color: rgba(255,255,255,0.85);
    padding: 10px 14px;
    margin-bottom: 6px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.parent-sidebar .nav-link i {
    font-size: 1.2rem;
}

/* Hover */
.parent-sidebar .nav-link:hover {
    background-color: rgba(255,255,255,0.15);
    color: #fff;
}

/* Active */
.parent-sidebar .nav-link.active {
    background-color: #fff;
    color: #0d6efd;
    font-weight: 600;
}

/* Divider */
.parent-sidebar hr {
    border-color: rgba(255,255,255,0.3);
}

/* Dark mode */
body.dark .parent-sidebar {
    background: linear-gradient(180deg, #020617, #020617);
}

body.dark .parent-sidebar .nav-link {
    color: #cbd5f5;
}

body.dark .parent-sidebar .nav-link.active {
    background-color: #1e293b;
    color: #fff;
}

/* Mobile */
@media (max-width: 992px) {
    .parent-sidebar {
        transform: translateX(-100%);
    }
    .parent-sidebar.show {
        transform: translateX(0);
    }
}

.notification-dropdown {
    width: 360px;
    border-radius: 18px;
    padding: 6px 0;
    background: rgba(255,255,255,.95);
    backdrop-filter: blur(12px);
}

/* Gradient title */
.text-gradient {
    background: linear-gradient(135deg, #4f46e5, #0d6efd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Item */
.notification-item {
    position: relative;
    padding: 12px 16px;
    border-radius: 14px;
    margin: 4px 8px;
    transition: all .3s ease;
}

/* Hover */
.notification-item:hover {
    background: rgba(79,70,229,.08);
    transform: translateX(3px);
}

/* Non lu */
.notification-item.unread {
    background: rgba(13,110,253,.06);
}

/* Dot non lu */
.notif-dot {
    position: absolute;
    right: 14px;
    top: 18px;
    width: 8px;
    height: 8px;
    background: #0d6efd;
    border-radius: 50%;
    box-shadow: 0 0 0 6px rgba(13,110,253,.15);
}

/* Footer link */
.see-all {
    transition: all .3s ease;
}

.see-all:hover {
    background: #0d6efd;
    color: #fff;
}

/* Small text */
.x-small {
    font-size: .7rem;
}
</style>
