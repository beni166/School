
<aside class="secretariat-sidebar" id="secretariatSidebar">
    <a href="{{ route('secretariat.dashboard') }}" class="school-brand">
        <span class="school-brand-icon">
            <i class="fas fa-school"></i>
        </span>
        <span>
            <strong>School</strong>
            <small>Gestion scolaire</small>
        </span>
    </a>

    <div class="sidebar-section-title">ESPACE PRINCIPAL</div>

    <nav class="sidebar-nav">
        <a href="{{ route('secretariat.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('secretariat.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i>
            <span>Tableau de bord</span>
        </a>

        <a href="{{ route('secretariat.inscriptions.index') }}"
           class="sidebar-link {{ request()->routeIs('secretariat.inscriptions.*') ? 'active' : '' }}">
            <i class="fas fa-file-signature"></i>
            <span>Inscriptions</span>
        </a>

        <a href="{{ route('secretariat.eleves.index') }}"
           class="sidebar-link {{ request()->routeIs('secretariat.eleves.*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate"></i>
            <span>Élèves</span>
        </a>

        <a href="{{ route('secretariat.classes.index') }}"
           class="sidebar-link {{ request()->routeIs('secretariat.classes.*') ? 'active' : '' }}">
            <i class="fas fa-chalkboard"></i>
            <span>Classes</span>
        </a>

        <a href="{{ route('secretariat.bulletins.index') }}"
           class="sidebar-link {{ request()->routeIs('secretariat.bulletins.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Bulletins</span>
        </a>

        <a href="{{ route('secretariat.presences.index') }}"
           class="sidebar-link {{ request()->routeIs('secretariat.presences.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i>
            <span>Présences</span>
        </a>
    </nav>

    <div class="sidebar-section-title">COMPTE</div>

    <nav class="sidebar-nav">
        <a href="{{ route('secretariat.profile.edit') }}" class="sidebar-link">
            <i class="fas fa-user-cog"></i>
            <span>Mon profil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link sidebar-logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </button>
        </form>
    </nav>

    <div class="sidebar-bottom">
        <i class="fas fa-graduation-cap"></i>
        <p>Ensemble pour l'excellence.</p>
    </div>
</aside>
