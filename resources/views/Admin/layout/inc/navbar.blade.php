
<nav class="school-navbar">
    <div class="navbar-left">
        <button type="button"
                class="sidebar-toggle"
                id="sidebarToggle"
                aria-label="Ouvrir ou fermer le menu">
            <i class="fas fa-bars"></i>
        </button>

        <div class="navbar-heading">
            <strong>
                {{ request()->routeIs('secretariat.*')
                    ? 'Espace secrétariat'
                    : 'Espace direction' }}
            </strong>
            <small>Gestion de votre établissement</small>
        </div>
    </div>

    <div class="navbar-right">
        <button type="button"
                class="navbar-icon-btn"
                title="Notifications"
                aria-label="Notifications">
            <i class="far fa-bell"></i>
            <span class="notification-dot"></span>
        </button>

        <div class="dropdown">
            <button class="user-dropdown dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <span class="navbar-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </span>

                <span class="navbar-user-info">
                    <strong>{{ auth()->user()->name ?? 'Utilisateur' }}</strong>
                    <small>{{ auth()->user()->role ?? 'Compte utilisateur' }}</small>
                </span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li>
                    <h6 class="dropdown-header">Mon compte</h6>
                </li>
                @if (\Illuminate\Support\Facades\Route::has('profile.edit'))
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-circle me-2"></i>
                            Mon profil
                        </a>
                    </li>
                @endif
                <li><hr class="dropdown-divider"></li>
                @if (\Illuminate\Support\Facades\Route::has('logout'))
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Déconnexion
                            </button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
