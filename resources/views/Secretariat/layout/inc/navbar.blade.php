
<nav class="secretariat-navbar">
    <div class="navbar-left">
        <button type="button" class="sidebar-toggle" id="sidebarToggle"
                aria-label="Ouvrir ou fermer le menu">
            <i class="fas fa-bars"></i>
        </button>

        <div>
            <h5>Espace secrétariat</h5>
            <small>Gestion de votre établissement</small>
        </div>
    </div>

    <div class="navbar-right">
        <span class="navbar-date d-none d-md-inline">
            <i class="far fa-calendar-alt me-2"></i>
            {{ now()->translatedFormat('l d F Y') }}
        </span>

        <div class="dropdown">
            <button class="user-menu dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <span class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                </span>

                <span class="user-info d-none d-md-flex">
                    <strong>{{ auth()->user()->name ?? 'Secrétariat' }}</strong>
                    <small>Secrétariat</small>
                </span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li>
                    <a class="dropdown-item" href="{{ route('secretary.profile.edit') }}">
                        <i class="fas fa-user me-2"></i> Mon profil
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
