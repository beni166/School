<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 parent-navbar">
    <!-- Toggle sidebar (mobile) -->
    <button class="btn btn-outline-secondary d-lg-none me-3" id="toggleSidebar">
        <i class="bi bi-list"></i>
    </button>

    <!-- Title -->
    <span class="navbar-brand fw-bold text-primary">
        Tableau de bord Sécretaire
    </span>

    <!-- Right zone -->
    <div class="ms-auto d-flex align-items-center gap-3">

        <!-- 🌙 Dark mode toggle -->
        <button id="darkToggle" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-moon"></i>
        </button>

        <!-- 🔔 Notifications -->
       {{-- @php
$parent = auth('parent')->user();
$notifications = $parent->unreadNotifications()->take(5)->get();
@endphp --}}

<li class="nav-item dropdown">
    <a class="nav-link position-relative" data-bs-toggle="dropdown">
        <i class="bi bi-bell fs-5"></i>

        {{-- @if($notifications->count())
            <span class="badge bg-danger">
                {{ $notifications->count() }}
            </span>
        @endif --}}
    </a>

    {{-- <ul class="dropdown-menu dropdown-menu-end shadow">
        <li class="dropdown-header fw-bold">Notifications</li>

        @forelse($notifications as $notif)
            <li>
                <a class="dropdown-item small"
                   href="{{ route('parent.notifications.read', $notif->id) }}">
                    <strong>{{ $notif->data['title'] }}</strong><br>
                    <span class="text-muted">{{ $notif->data['message'] }}</span>
                </a>
            </li>
        @empty
            <li class="dropdown-item text-muted text-center">
                Aucune notification
            </li>
        @endforelse
    </ul> --}}
</li>


        <!-- 👤 Profile -->
        <div class="dropdown">
            <a class="d-flex align-items-center text-decoration-none dropdown-toggle"
               href="#" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name="
                     class="rounded-circle me-2" width="38">
                <span class="fw-semibold">
                   
                </span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-person me-2"></i> Mon profil
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form method="POST" action="">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<style>
/* Navbar */
.parent-navbar {
    height: 64px;
}

/* Notifications */
.notification-dropdown {
    width: 280px;
}

/* Dark mode */
body.dark {
    background-color: #0f172a;
    color: #e5e7eb;
}

body.dark .navbar,
body.dark .dropdown-menu,
body.dark .card,
body.dark footer {
    background-color: #1e293b !important;
    color: #e5e7eb;
}

body.dark .dropdown-item {
    color: #e5e7eb;
}

body.dark .dropdown-item:hover {
    background-color: #334155;
}

body.dark .btn-outline-secondary {
    border-color: #64748b;
    color: #e5e7eb;
}
</style>
