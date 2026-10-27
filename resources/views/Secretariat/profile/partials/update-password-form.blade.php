<section class="password-section">

    {{-- En-tête --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="password-icon">
            <i class="fas fa-shield-alt"></i>
        </div>

        <div>
            <h4 class="fw-bold text-dark mb-1">
                Sécurité du compte
            </h4>
            <p class="text-muted mb-0">
                Modifiez votre mot de passe pour protéger votre compte.
            </p>
        </div>
    </div>

    {{-- Notification de succès --}}
    @if (session('status') === 'password-updated')
        <div class="alert alert-success border-0 rounded-3 d-flex align-items-center gap-2 mb-4"
             role="alert">
            <i class="fas fa-check-circle fa-lg"></i>
            <span>Votre mot de passe a été modifié avec succès.</span>
        </div>
    @endif

    {{-- Carte de sécurité --}}
    <div class="card password-card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">

            <form method="post"
                  action="{{ route('password.update') }}"
                  class="password-form">

                @csrf
                @method('put')

                {{-- Mot de passe actuel --}}
                <div class="mb-4">
                    <label for="update_password_current_password"
                           class="form-label fw-semibold">
                        Mot de passe actuel
                    </label>

                    <div class="input-group password-input">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>

                        <input
                            id="update_password_current_password"
                            name="current_password"
                            type="password"
                            class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif"
                            placeholder="Entrez votre mot de passe actuel"
                            autocomplete="current-password"
                        >

                        <button type="button"
                                class="input-group-text password-toggle"
                                data-target="update_password_current_password"
                                aria-label="Afficher le mot de passe actuel">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    @if ($errors->updatePassword->has('current_password'))
                        <div class="text-danger small mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $errors->updatePassword->first('current_password') }}
                        </div>
                    @endif
                </div>

                {{-- Nouveau mot de passe --}}
                <div class="mb-4">
                    <label for="update_password_password"
                           class="form-label fw-semibold">
                        Nouveau mot de passe
                    </label>

                    <div class="input-group password-input">
                        <span class="input-group-text">
                            <i class="fas fa-key"></i>
                        </span>

                        <input
                            id="update_password_password"
                            name="password"
                            type="password"
                            class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif"
                            placeholder="Créez un nouveau mot de passe"
                            autocomplete="new-password"
                        >

                        <button type="button"
                                class="input-group-text password-toggle"
                                data-target="update_password_password"
                                aria-label="Afficher le nouveau mot de passe">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    @if ($errors->updatePassword->has('password'))
                        <div class="text-danger small mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $errors->updatePassword->first('password') }}
                        </div>
                    @endif

                    <div class="form-text mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        Choisissez un mot de passe long et difficile à deviner.
                    </div>
                </div>

                {{-- Confirmation --}}
                <div class="mb-4">
                    <label for="update_password_password_confirmation"
                           class="form-label fw-semibold">
                        Confirmer le nouveau mot de passe
                    </label>

                    <div class="input-group password-input">
                        <span class="input-group-text">
                            <i class="fas fa-check-double"></i>
                        </span>

                        <input
                            id="update_password_password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
                            placeholder="Retapez le nouveau mot de passe"
                            autocomplete="new-password"
                        >

                        <button type="button"
                                class="input-group-text password-toggle"
                                data-target="update_password_password_confirmation"
                                aria-label="Afficher la confirmation du mot de passe">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    @if ($errors->updatePassword->has('password_confirmation'))
                        <div class="text-danger small mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            {{ $errors->updatePassword->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <hr class="my-4">

                {{-- Bouton de sauvegarde --}}
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <button type="submit" class="btn btn-primary btn-password-save">
                        <i class="fas fa-save me-2"></i>
                        Enregistrer le nouveau mot de passe
                    </button>
                </div>

            </form>
        </div>
    </div>

</section>

<style>
    .password-section {
        width: 100%;
        color: #1e293b;
    }

    .password-icon {
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

    .password-card {
        border-radius: 20px;
        background: #fff;
        overflow: hidden;
    }

    .password-form {
        max-width: 760px;
    }

    .password-form .form-label {
        color: #334155;
        font-size: .92rem;
        margin-bottom: 9px;
    }

    .password-input {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        background: #f8fafc;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .password-input .input-group-text {
        border: 0;
        background: transparent;
        color: #64748b;
        padding-left: 16px;
    }

    .password-input .form-control {
        min-height: 50px;
        border: 0;
        background: transparent;
        box-shadow: none;
        color: #0f172a;
    }

    .password-input .form-control::placeholder {
        color: #94a3b8;
        font-size: .9rem;
    }

    .password-input:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .10);
        background: #fff;
    }

    .password-input:focus-within .input-group-text {
        color: #2563eb;
    }

    .password-toggle {
        cursor: pointer;
        padding-right: 16px !important;
        transition: color .2s ease;
    }

    .password-toggle:hover {
        color: #2563eb;
    }

    .btn-password-save {
        min-height: 46px;
        padding: 11px 22px;
        border: none;
        border-radius: 11px;
        font-weight: 600;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        box-shadow: 0 5px 14px rgba(37, 99, 235, .18);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .btn-password-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, .25);
        background: linear-gradient(135deg, #1d4ed8, #4338ca);
    }

    .password-section .alert {
        font-size: .9rem;
    }

    @media (max-width: 576px) {
        .password-card .card-body {
            padding: 22px !important;
        }

        .btn-password-save {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.password-toggle').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(
                    this.getAttribute('data-target')
                );

                const icon = this.querySelector('i');

                if (!input || !icon) return;

                const afficher = input.type === 'password';

                input.type = afficher ? 'text' : 'password';

                icon.classList.toggle('fa-eye', !afficher);
                icon.classList.toggle('fa-eye-slash', afficher);

                this.setAttribute(
                    'aria-label',
                    afficher ? 'Masquer le mot de passe' : 'Afficher le mot de passe'
                );
            });
        });
    });
</script>