
@php
    $currentRole = auth()->user()->role ?? 'secretariat';

    $isDirector = in_array($currentRole, [
        'director',
        'directeur',
        'admin',
        'administrateur',
    ]);

    $menuGroups = $isDirector ? [
        [
            'title' => 'ESPACE PRINCIPAL',
            'items' => [
                [
                    'label' => 'Tableau de bord',
                    'icon' => 'fas fa-th-large',
                    'routes' => ['director.dashboard', 'dashboard'],
                    'active' => ['director.dashboard', 'dashboard'],
                ],
            ],
        ],
        [
            'title' => 'GESTION SCOLAIRE',
            'items' => [
                [
                    'label' => 'Élèves',
                    'icon' => 'fas fa-user-graduate',
                    'routes' => ['director.eleves.index', 'Eleve.index'],
                    'active' => ['director.eleves.*', 'Eleve.*'],
                ],
                [
                    'label' => 'Professeurs',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'routes' => ['director.professeurs.index', 'professeurs.index'],
                    'active' => ['director.professeurs.*', 'professeurs.*'],
                ],
                [
                    'label' => 'Inscriptions',
                    'icon' => 'fas fa-user-plus',
                    'routes' => ['director.inscriptions.index'],
                    'active' => ['director.inscriptions.*'],
                ],
                [
                    'label' => 'Classes',
                    'icon' => 'fas fa-school',
                    'routes' => ['director.classes.index'],
                    'active' => ['director.classes.*'],
                ],
                [
                    'label' => 'Niveaux',
                    'icon' => 'fas fa-layer-group',
                    'routes' => ['director.niveau.index', 'niveaux.index'],
                    'active' => ['director.niveau.*', 'niveaux.*'],
                ],
                [
                    'label' => 'Cycles scolaires',
                    'icon' => 'fas fa-sitemap',
                    'routes' => ['director.cycle.index', 'cycles.index'],
                    'active' => ['director.cycle.*', 'cycles.*'],
                ],
                [
                    'label' => 'Années scolaires',
                    'icon' => 'fas fa-calendar-alt',
                    'routes' => ['director.annees-scolaires.index'],
                    'active' => ['director.annees-scolaires.*'],
                ],
            ],
        ],
        [
            'title' => 'PÉDAGOGIE',
            'items' => [
                [
                    'label' => 'Matières',
                    'icon' => 'fas fa-book-open',
                    'routes' => ['director.matieres.index', 'Matiere.index'],
                    'active' => ['director.matieres.*', 'Matiere.*'],
                ],
                [
                    'label' => 'Programmes de classe',
                    'icon' => 'fas fa-book-reader',
                    'routes' => ['director.programmes-classes.index'],
                    'active' => ['director.programmes-classes.*'],
                ],
                [
                    'label' => 'Affectations',
                    'icon' => 'fas fa-user-tie',
                    'routes' => ['director.affectations.index'],
                    'active' => ['director.affectations.*'],
                ],
                [
                    'label' => 'Périodes scolaires',
                    'icon' => 'fas fa-calendar-week',
                    'routes' => ['director.periodes.index'],
                    'active' => ['director.periodes.*'],
                ],
                [
                    'label' => 'Saisie des notes',
                    'icon' => 'fas fa-pen-alt',
                    'routes' => ['director.notes.index'],
                    'active' => ['director.notes.*'],
                ],
                [
                    'label' => 'Bulletins',
                    'icon' => 'fas fa-file-alt',
                    'routes' => ['director.bulletins.index', 'director.Bulletin.index'],
                    'active' => ['director.bulletins.*', 'director.Bulletin.*'],
                ],
                [
                    'label' => 'Détails des bulletins',
                    'icon' => 'fas fa-list-alt',
                    'routes' => ['director.bulletins-details.index'],
                    'active' => ['director.bulletins-details.*'],
                ],
            ],
        ],
    ] : [
        [
            'title' => 'ESPACE PRINCIPAL',
            'items' => [
                [
                    'label' => 'Tableau de bord',
                    'icon' => 'fas fa-th-large',
                    'routes' => ['secretariat.dashboard'],
                    'active' => ['secretariat.dashboard'],
                ],
            ],
        ],
        [
            'title' => 'ACCUEIL ET DOSSIERS',
            'items' => [
                [
                    'label' => 'Inscriptions',
                    'icon' => 'fas fa-user-plus',
                    'routes' => ['director.inscriptions.index'],
                    'active' => ['director.inscriptions.*'],
                ],
                [
                    'label' => 'Élèves',
                    'icon' => 'fas fa-user-graduate',
                    'routes' => ['director.eleves.index', 'Eleve.index'],
                    'active' => ['director.eleves.*', 'Eleve.*'],
                ],
                [
                    'label' => 'Classes',
                    'icon' => 'fas fa-school',
                    'routes' => ['director.classes.index'],
                    'active' => ['director.classes.*'],
                ],
                [
                    'label' => 'Bulletins',
                    'icon' => 'fas fa-file-alt',
                    'routes' => ['director.bulletins.index'],
                    'active' => ['director.bulletins.*'],
                ],
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
        </div>
    </div>

    <div class="sidebar-profile">
        <div class="profile-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
        </div>
        <div class="profile-info">
            <strong>{{ auth()->user()->name ?? 'Utilisateur' }}</strong>
            <small>{{ $isDirector ? 'Direction' : 'Secrétariat' }}</small>
        </div>
    </div>

    <nav class="sidebar-navigation">
        @foreach ($menuGroups as $group)
            <div class="sidebar-group">
                <div class="sidebar-group-title">
                    {{ $group['title'] }}
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
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                            @if ($isActive)
                                <span class="active-indicator"></span>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <div class="footer-school-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
            <strong>École de l'Avenir</strong>
            <small>Discipline · Travail · Réussite</small>
        </div>
    </div>
</aside>
