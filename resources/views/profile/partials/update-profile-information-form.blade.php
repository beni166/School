<section class="profile-section">

    {{-- En-tête --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="profile-icon">
            <i class="fas fa-user-edit"></i>
        </div>

        <div>
            <h4 class="fw-bold text-dark mb-1">
                Informations du profil
            </h4>
            <p class="text-muted mb-0">
                Gérez votre nom et votre adresse e-mail.
            </p>
        </div>
    </div>

    {{-- Notification de succès --}}
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success border-0 rounded-3 d-flex align-items-center gap-2 mb-4"
             role="alert">
            <i class="fas fa-check-circle fa-lg"></i>
            <span>Votre profil a été mis à jour avec succès.</span>
        </div>
    @endif

    {{-- Carte du profil --}}
    <div class="card profile-card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">

            {{-- Formulaire de vérification de l'e-mail --}}
            <form id="send-verification"
                  method="post"
                  action="{{ route('verification.send') }}">
                @csrf
            </form>

            {{-- Formulaire principal --}}
            <form method="post"
                  action="{{ route('profile.update') }}"
                  class="profile-form">

                @csrf
                @method('patch')

                {{-- Nom --}}
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">
                        Nom complet
                    </label>

                    <div class="input-group modern-input">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Entrez votre nom complet"
                            required
                            autofocus
                            autocomplete="name"
                        >
                    </div>

                    @error('name')
                        <div class="text-danger small mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Adresse e-mail --}}
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">
                        Adresse e-mail
                    </label>

                    <div class="input-group modern-input">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}"
                            placeholder="exemple@domaine.com"
                            required
                            autocomplete="username"
                        >
                    </div>

                    @error('email')
                        <div class="text-danger small mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Statut de vérification --}}
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail)
                        <div class="email-status mt-3">
                            @if ($user->hasVerifiedEmail())
                                <span class="status-verified">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Adresse e-mail vérifiée
                                </span>
                            @else
                                <span class="status-unverified">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Adresse e-mail non vérifiée
                                </span>

                                <p class="text-muted small mt-2 mb-2">
                                    Vérifiez votre adresse e-mail pour sécuriser votre compte.
                                </p>

                                <button
                                    form="send-verification"
                                    type="submit"
                                    class="btn btn-sm btn-outline-primary rounded-3">
                                    <i class="fas fa-paper-plane me-1"></i>
                                    Renvoyer le lien de vérification
                                </button>

                                @if (session('status') === 'verification-link-sent')
                                    <div class="alert alert-success py-2 px-3 mt-3 mb-0 rounded-3 small">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Un nouveau lien de vérification a été envoyé.
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Séparateur --}}
                <hr class="my-4">

                {{-- Boutons --}}
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <button type="submit" class="btn btn-primary btn-save">
                        <i class="fas fa-save me-2"></i>
                        Enregistrer les modifications
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span class="text-success small"
                              id="saved-message">
                            <i class="fas fa-check-circle me-1"></i>
                            Modifications enregistrées
                        </span>
                    @endif
                </div>

            </form>
        </div>
    </div>

</section>

<style>
    .profile-section {
        width: 100%;
        color: #1e293b;
    }

    .profile-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 16px;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 6px 18px rgba(37, 99, 235, .20);
    }

    .profile-card {
        border-radius: 20px;
        background: #fff;
        overflow: hidden;
    }

    .profile-form {
        max-width: 760px;
    }

    .profile-form .form-label {
        color: #334155;
        font-size: .92rem;
        margin-bottom: 9px;
    }

    .modern-input {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: border-color .2s ease, box-shadow .2s ease;
        background: #f8fafc;
    }

    .modern-input .input-group-text {
        border: 0;
        background: transparent;
        color: #64748b;
        padding-left: 16px;
    }

    .modern-input .form-control {
        min-height: 50px;
        border: 0;
        background: transparent;
        box-shadow: none;
        color: #0f172a;
    }

    .modern-input:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .10);
        background: #fff;
    }

    .modern-input:focus-within .input-group-text {
        color: #2563eb;
    }

    .modern-input .form-control::placeholder {
        color: #94a3b8;
    }

    .status-verified,
    .status-unverified {
        display: inline-flex;
        align-items: center;
        padding: 7px 12px;
        border-radius: 30px;
        font-size: .82rem;
        font-weight: 600;
    }

    .status-verified {
        color: #15803d;
        background: #dcfce7;
    }

    .status-unverified {
        color: #b45309;
        background: #fef3c7;
    }

    .btn-save {
        min-height: 46px;
        padding: 11px 22px;
        border: none;
        border-radius: 11px;
        font-weight: 600;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        box-shadow: 0 5px 14px rgba(37, 99, 235, .18);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, .25);
        background: linear-gradient(135deg, #1d4ed8, #4338ca);
    }

    .profile-section .alert {
        font-size: .9rem;
    }

    @media (max-width: 576px) {
        .profile-card .card-body {
            padding: 22px !important;
        }

        .btn-save {
            width: 100%;
        }
    }
</style>