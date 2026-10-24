@extends('admin.layout.app')

@section('content')
    

    <div class="profile-page">

        {{-- En-tête de la page --}}
        <div class="profile-header">
            <div class="container-fluid px-3 px-lg-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div class="d-flex align-items-center gap-3">
                        <div class="profile-header-icon">
                            <i class="fas fa-user-cog"></i>
                        </div>

                        <div>
                            <h2 class="profile-title">
                                Paramètres du compte
                            </h2>

                            <p class="profile-subtitle mb-0">
                                Gérez vos informations personnelles et la sécurité de votre compte.
                            </p>
                        </div>
                    </div>

                    <div class="profile-breadcrumb">
                        <i class="fas fa-home me-2"></i>
                        <span>Accueil</span>
                        <i class="fas fa-chevron-right mx-2"></i>
                        <span class="active">Mon profil</span>
                    </div>

                </div>
            </div>
        </div>

        {{-- Contenu principal --}}
        <div class="container-fluid px-3 px-lg-4 py-4 py-lg-5">

            <div class="row g-4">

                {{-- Navigation latérale --}}
                <div class="col-12 col-xl-3">

                    <div class="card profile-sidebar border-0 shadow-sm">
                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <div class="profile-avatar mx-auto mb-3">
                                    <i class="fas fa-user"></i>
                                </div>

                                <h5 class="fw-bold mb-1">
                                    {{ Auth::user()->name }}
                                </h5>

                                <p class="text-muted small mb-0">
                                    {{ Auth::user()->email }}
                                </p>

                                <span class="profile-badge mt-3">
                                    <i class="fas fa-circle me-1"></i>
                                    Compte actif
                                </span>
                            </div>

                            <hr class="my-4">

                            <p class="sidebar-label">PARAMÈTRES</p>

                            <a href="#informations"
                               class="profile-nav-link active">
                                <i class="fas fa-user-edit"></i>
                                <span>Informations personnelles</span>
                            </a>

                            <a href="#securite"
                               class="profile-nav-link">
                                <i class="fas fa-lock"></i>
                                <span>Mot de passe</span>
                            </a>

                            <a href="#suppression"
                               class="profile-nav-link text-danger">
                                <i class="fas fa-trash-alt"></i>
                                <span>Suppression du compte</span>
                            </a>

                        </div>
                    </div>

                    {{-- Conseil de sécurité --}}
                    <div class="security-tip mt-4">
                        <div class="d-flex gap-3">
                            <i class="fas fa-shield-alt"></i>

                            <div>
                                <h6 class="fw-bold mb-1">
                                    Conseil de sécurité
                                </h6>

                                <p class="small mb-0">
                                    Utilisez un mot de passe long et unique pour protéger votre compte.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Formulaires --}}
                <div class="col-12 col-xl-9">

                    {{-- Informations personnelles --}}
                    <div id="informations" class="profile-panel mb-4">
                       @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Sécurité et mot de passe --}}
                    <div id="securite" class="profile-panel mb-4">
                        @include('profile.partials.update-password-form')

                    </div>

                    {{-- Suppression du compte --}}
                    <div id="suppression" class="profile-panel">
                       @include('profile.partials.delete-user-form')
                    </div>

                </div>

            </div>
        </div>

    </div>

    <style>
        .profile-page {
            min-height: 100vh;
            background: #f5f7fb;
            color: #1e293b;
        }

        .profile-header {
            background: #fff;
            padding: 28px 0;
            border-bottom: 1px solid #e9edf5;
        }

        .profile-header-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #fff;
            font-size: 1.4rem;
            box-shadow: 0 6px 18px rgba(37, 99, 235, .18);
            flex-shrink: 0;
        }

        .profile-title {
            font-size: 1.55rem;
            font-weight: 800;
            letter-spacing: -.4px;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .profile-subtitle {
            font-size: .92rem;
            color: #64748b;
        }

        .profile-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            color: #94a3b8;
            font-size: .85rem;
        }

        .profile-breadcrumb .active {
            color: #2563eb;
            font-weight: 600;
        }

        .profile-sidebar {
            border-radius: 20px;
            position: sticky;
            top: 24px;
        }

        .profile-avatar {
            width: 82px;
            height: 82px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 25px;
            background: linear-gradient(135deg, #dbeafe, #e0e7ff);
            color: #3158bd;
            font-size: 2rem;
        }

        .profile-badge {
            display: inline-block;
            padding: 7px 13px;
            border-radius: 30px;
            background: #dcfce7;
            color: #15803d;
            font-size: .78rem;
            font-weight: 600;
        }

        .profile-badge i {
            font-size: .5rem;
            vertical-align: middle;
        }

        .sidebar-label {
            color: #94a3b8;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .profile-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin-bottom: 7px;
            border-radius: 11px;
            text-decoration: none;
            color: #475569;
            font-size: .9rem;
            font-weight: 500;
            transition: all .2s ease;
        }

        .profile-nav-link i {
            width: 19px;
            text-align: center;
        }

        .profile-nav-link:hover,
        .profile-nav-link.active {
            background: #eff6ff;
            color: #2563eb;
        }

        .profile-nav-link.text-danger:hover {
            background: #fef2f2;
            color: #dc2626 !important;
        }

        .security-tip {
            padding: 20px;
            border: 1px solid #dbeafe;
            border-radius: 16px;
            background: #eff6ff;
            color: #1e40af;
        }

        .security-tip > div > i {
            font-size: 1.35rem;
            margin-top: 2px;
        }

        .security-tip p {
            color: #475569;
            line-height: 1.6;
        }

        .profile-panel {
            background: #fff;
            border: 1px solid #edf0f5;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .035);
            scroll-margin-top: 24px;
        }

        /* Évite les marges excessives dans les anciens formulaires. */
        .profile-panel > section {
            width: 100%;
        }

        html {
            scroll-behavior: smooth;
        }

        @media (max-width: 1199.98px) {
            .profile-sidebar {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .profile-header {
                padding: 22px 0;
            }

            .profile-title {
                font-size: 1.25rem;
            }

            .profile-subtitle {
                font-size: .85rem;
            }

            .profile-panel {
                padding: 20px;
                border-radius: 16px;
            }

            .profile-breadcrumb {
                display: none;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.profile-nav-link');

            links.forEach(function (link) {
                link.addEventListener('click', function () {
                    links.forEach(function (item) {
                        item.classList.remove('active');
                    });

                    if (!link.classList.contains('text-danger')) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>

@endsection