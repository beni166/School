
@php
    $currentRole = auth()->user()->role ?? 'secretariat';

    $isDirector = in_array($currentRole, [
        'director', 'directeur', 'admin', 'administrateur'
    ]);

    $menuGroups = $isDirector ? [
        [
            'title' => 'GESTION SCOLAIRE',
            'items' => [
                ['label' => 'Élèves', 'icon' => 'fas fa-user-graduate', 'routes' => ['director.eleves.index', 'Eleve.index'], 'active' => ['director.eleves.*', 'Eleve.*']],
                ['label' => 'Professeurs', 'icon' => 'fas fa-chalkboard-teacher', 'routes' => ['director.professeurs.index', 'professeurs.index'], 'active' => ['director.professeurs.*', 'professeurs.*']],
                ['label' => 'Inscriptions', 'icon' => 'fas fa-file-signature', 'routes' => ['director.inscriptions.index'], 'active' => ['director.inscriptions.*']],
                ['label' => 'Classes', 'icon' => 'fas fa-school', 'routes' => ['director.classes.index'], 'active' => ['director.classes.*']],
                ['label' => 'Niveaux', 'icon' => 'fas fa-layer-group', 'routes' => ['director.niveau.index', 'niveaux.index'], 'active' => ['director.niveau.*', 'niveaux.*']],
                ['label' => 'Cycles scolaires', 'icon' => 'fas fa-sitemap', 'routes' => ['director.cycle.index', 'cycles.index'], 'active' => ['director.cycle.*', 'cycles.*']],
                ['label' => 'Années scolaires', 'icon' => 'fas fa-calendar-alt', 'routes' => ['director.annees-scolaires.index'], 'active' => ['director.annees-scolaires.*']],
            ],
        ],
        [
            'title' => 'PÉDAGOGIE',
            'items' => [
                ['label' => 'Matières', 'icon' => 'fas fa-book-open', 'routes' => ['director.matieres.index', 'Matiere.index'], 'active' => ['director.matieres.*', 'Matiere.*']],
                ['label' => 'Programmes de classe', 'icon' => 'fas fa-book-reader', 'routes' => ['director.programmes-classes.index'], 'active' => ['director.programmes-classes.*']],
                ['label' => 'Affectations', 'icon' => 'fas fa-user-tie', 'routes' => ['director.affectations.index'], 'active' => ['director.affectations.*']],
                ['label' => 'Périodes scolaires', 'icon' => 'fas fa-calendar-week', 'routes' => ['director.periodes.index'], 'active' => ['director.periodes.*']],
                ['label' => 'Saisie des notes', 'icon' => 'fas fa-pen-alt', 'routes' => ['director.notes.index'], 'active' => ['director.notes.*']],
                ['label' => 'Bulletins', 'icon' => 'fas fa-file-alt', 'routes' => ['director.bulletins.index', 'director.Bulletin.index'], 'active' => ['director.bulletins.*', 'director.Bulletin.*']],
                ['label' => 'Détails des bulletins', 'icon' => 'fas fa-list-alt', 'routes' => ['director.bulletins-details.index'], 'active' => ['director.bulletins-details.*']],
            ],
        ],
    ] : [
        [
            'title' => 'ACCUEIL ET DOSSIERS',
            'items' => [
                ['label' => 'Inscriptions', 'icon' => 'fas fa-file-signature', 'routes' => ['secretariat.inscriptions.index', 'director.inscriptions.index'], 'active' => ['secretariat.inscriptions.*', 'director.inscriptions.*']],
                ['label' => 'Élèves', 'icon' => 'fas fa-user-graduate', 'routes' => ['secretariat.eleves.index', 'director.eleves.index', 'Eleve.index'], 'active' => ['secretariat.eleves.*', 'director.eleves.*', 'Eleve.*']],
                ['label' => 'Classes', 'icon' => 'fas fa-school', 'routes' => ['secretariat.classes.index', 'director.classes.index'], 'active' => ['secretariat.classes.*', 'director.classes.*']],
                ['label' => 'Bulletins', 'icon' => 'fas fa-file-alt', 'routes' => ['secretariat.bulletins.index', 'director.bulletins.index'], 'active' => ['secretariat.bulletins.*', 'director.bulletins.*']],
            ],
        ],
    ];
@endphp

<aside class="school-sidebar" id="schoolSidebar">

    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="fas fa-school"></i>
        </div>
        <div class="brand-text">
            <strong>School</strong>
            <small>Gestion scolaire</small>
            <span>Discipline · Travail · Réussite</span>
        </div>
    </div>

    <div class="sidebar-profile">
        <div class="profile-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            <span class="online-dot"></span>
        </div>

        <div class="profile-info">
            <strong>{{ auth()->user()->name ?? 'Utilisateur' }}</strong>
            <small>{{ $isDirector ? 'Directeur' : 'Secrétariat' }}</small>
        </div>

        <i class="fas fa-chevron-down profile-chevron"></i>
    </div>

    <nav class="sidebar-navigation">

        <div class="sidebar-group">
            <a href="{{ \Illuminate\Support\Facades\Route::has('director.dashboard') ? route('director.dashboard') : ( \Illuminate\Support\Facades\Route::has('secretariat.dashboard') ? route('secretariat.dashboard') : '#' ) }}"
               class="sidebar-link dashboard-link {{ request()->routeIs('director.dashboard', 'secretariat.dashboard', 'dashboard') ? 'active' : '' }}">
                <i class="fas fa-house"></i>
                <span>Tableau de bord</span>
                <i class="fas fa-chevron-right link-arrow"></i>
            </a>
        </div>

        @foreach ($menuGroups as $group)
            <div class="sidebar-group">
                <div class="sidebar-group-title">
                    <span>{{ $group['title'] }}</span>
                    <span class="group-line"></span>
                </div>

                @foreach ($group['items'] as $item)
                    @php
                        $availableRoute = collect($item['routes'])
                            ->first(fn ($route) => \Illuminate\Support\Facades\Route::has($route));

                        $isActive = collect($item['active'])
                            ->contains(fn ($pattern) => request()->routeIs($pattern));
                    @endphp

                    @if ($availableRoute)
                        <a href="{{ route($availableRoute) }}"
                           class="sidebar-link {{ $isActive ? 'active' : '' }}">
                            <i class="{{ $item['icon'] }} menu-icon"></i>
                            <span>{{ $item['label'] }}</span>
                            <i class="fas fa-chevron-right link-arrow"></i>
                        </a>
                    @endif
                @endforeach
            </div>
        @endforeach

        @if (\Illuminate\Support\Facades\Route::has('profile.edit'))
            <div class="sidebar-group sidebar-settings">
                <a href="{{ route('profile.edit') }}" class="sidebar-link">
                    <i class="fas fa-cog menu-icon"></i>
                    <span>Paramètres</span>
                    <i class="fas fa-chevron-right link-arrow"></i>
                </a>
            </div>
        @endif

    </nav>

    <div class="sidebar-footer">
        <div class="footer-school-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="footer-school-text">
            <strong>École de l'Avenir</strong>
            <small>Discipline · Travail · Réussite</small>
        </div>
    </div>

</aside>
