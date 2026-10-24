<section class="delete-account-section">

    {{-- En-tête --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="delete-account-icon">
            <i class="fas fa-user-slash"></i>
        </div>

        <div>
            <h4 class="fw-bold text-dark mb-1">
                Suppression du compte
            </h4>
            <p class="text-muted mb-0">
                Gérez la suppression définitive de votre compte.
            </p>
        </div>
    </div>

    {{-- Carte de suppression --}}
    <div class="card delete-account-card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">

            <div class="d-flex align-items-start gap-3">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>

                <div class="flex-grow-1">
                    <h5 class="fw-bold text-dark mb-2">
                        Supprimer définitivement votre compte
                    </h5>

                    <p class="text-muted mb-3">
                        Cette action est irréversible. La suppression de votre compte
                        peut entraîner la perte définitive de vos données et des
                        ressources qui lui sont associées.
                    </p>

                    <div class="deletion-warning mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Assurez-vous d'avoir sauvegardé les informations que vous
                        souhaitez conserver avant de continuer.
                    </div>

                    <button
                        type="button"
                        class="btn btn-danger btn-delete-account"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmUserDeletion">

                        <i class="fas fa-trash-alt me-2"></i>
                        Supprimer mon compte
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal de confirmation --}}
    <div class="modal fade"
         id="confirmUserDeletion"
         tabindex="-1"
         aria-labelledby="confirmUserDeletionLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-modal border-0">

                {{-- En-tête du modal --}}
                <div class="modal-header border-0 px-4 pt-4 pb-0">
                    <div class="modal-warning-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fermer"></button>
                </div>

                {{-- Contenu --}}
                <div class="modal-body px-4 pt-3 pb-4">

                    <h5 class="fw-bold text-dark mb-2"
                        id="confirmUserDeletionLabel">
                        Confirmer la suppression
                    </h5>

                    <p class="text-muted mb-4">
                        Êtes-vous sûr de vouloir supprimer votre compte ?
                        Cette opération est définitive et peut supprimer
                        les données associées à votre compte.
                    </p>

                    <div class="alert alert-danger border-0 rounded-3 small mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Entrez votre mot de passe pour confirmer cette opération.
                    </div>

                    {{-- Formulaire Laravel --}}
                    <form method="post"
                          action="{{ route('profile.destroy') }}"
                          id="deleteAccountForm">

                        @csrf
                        @method('delete')

                        <div class="mb-4">
                            <label for="delete_account_password"
                                   class="form-label fw-semibold">
                                Mot de passe actuel
                            </label>

                            <div class="input-group delete-password-input">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>

                                <input
                                    id="delete_account_password"
                                    name="password"
                                    type="password"
                                    class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif"
                                    placeholder="Entrez votre mot de passe"
                                    autocomplete="current-password"
                                    required
                                >

                                <button type="button"
                                        class="input-group-text delete-password-toggle"
                                        aria-label="Afficher le mot de passe">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            @if($errors->userDeletion->has('password'))
                                <div class="text-danger small mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $errors->userDeletion->first('password') }}
                                </div>
                            @endif
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">

                            <button type="button"
                                    class="btn btn-light btn-cancel-delete"
                                    data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>
                                Annuler
                            </button>

                            <button type="submit"
                                    class="btn btn-danger btn-confirm-delete">
                                <i class="fas fa-trash-alt me-2"></i>
                                Confirmer la suppression
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<style>
    .delete-account-section {
        width: 100%;
        color: #1e293b;
    }

    .delete-account-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 16px;
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 6px 18px rgba(220, 38, 38, .18);
    }

    .delete-account-card {
        border-radius: 20px;
        background: #fff;
        overflow: hidden;
    }

    .warning-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 13px;
        background: #fef2f2;
        color: #dc2626;
        font-size: 1.1rem;
    }

    .deletion-warning {
        padding: 13px 15px;
        border-radius: 11px;
        background: #fff7ed;
        color: #9a3412;
        font-size: .88rem;
        line-height: 1.6;
    }

    .btn-delete-account,
    .btn-confirm-delete {
        border-radius: 10px;
        padding: 11px 18px;
        font-weight: 600;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .btn-delete-account:hover,
    .btn-confirm-delete:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(220, 38, 38, .2);
    }

    .delete-modal {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(15, 23, 42, .18);
    }

    .modal-warning-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: #fee2e2;
        color: #dc2626;
        font-size: 1.35rem;
    }

    .delete-password-input {
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        overflow: hidden;
        background: #f8fafc;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .delete-password-input:focus-within {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, .10);
        background: #fff;
    }

    .delete-password-input .input-group-text {
        border: 0;
        background: transparent;
        color: #64748b;
        padding-left: 14px;
    }

    .delete-password-input .form-control {
        min-height: 48px;
        border: 0;
        background: transparent;
        box-shadow: none;
    }

    .delete-password-toggle {
        cursor: pointer;
        padding-right: 14px !important;
    }

    .delete-password-toggle:hover {
        color: #dc2626;
    }

    .btn-cancel-delete {
        border-radius: 10px;
        padding: 11px 18px;
        font-weight: 600;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-cancel-delete:hover {
        background: #f1f5f9;
    }

    @media (max-width: 576px) {
        .delete-account-card .card-body {
            padding: 22px !important;
        }

        .delete-account-section .d-flex.align-items-start {
            gap: 12px !important;
        }

        .btn-delete-account {
            width: 100%;
        }

        .delete-modal .modal-body {
            padding: 20px !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.querySelector('.delete-password-toggle');
        const passwordInput = document.getElementById('delete_account_password');

        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function () {
                const icon = this.querySelector('i');
                const afficher = passwordInput.type === 'password';

                passwordInput.type = afficher ? 'text' : 'password';

                icon.classList.toggle('fa-eye', !afficher);
                icon.classList.toggle('fa-eye-slash', afficher);

                this.setAttribute(
                    'aria-label',
                    afficher ? 'Masquer le mot de passe' : 'Afficher le mot de passe'
                );
            });
        }

        // Si Laravel renvoie une erreur de mot de passe,
        // rouvrir automatiquement le modal.
        @if ($errors->userDeletion->isNotEmpty())
            const modalElement = document.getElementById('confirmUserDeletion');

            if (modalElement && window.bootstrap) {
                bootstrap.Modal.getOrCreateInstance(modalElement).show();
            }
        @endif
    });
</script>