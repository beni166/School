<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'School') }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          rel="stylesheet">

    {{-- Ton design personnalisé --}}
    <link rel="stylesheet" href="{{ asset('assets/Auth/css/Sytle.css') }}">

</head>

<body>
        
    <div class="auth-shell">

        {{-- Panneau de présentation --}}
        <section class="auth-presentation">
            <a href="/" class="auth-brand">
                <span class="auth-brand-icon">
                    <i class="fas fa-school"></i>
                </span>

                <span>
                    <strong>School</strong>
                    <small>Gestion scolaire</small>
                </span>
            </a>

            <div class="auth-welcome">
                <span class="auth-eyebrow">ESPACE SÉCURISÉ</span>
                <h1>Rejoignez-nous !</h1>

                <p>
                    Créez votre compte pour accéder aux services
                    de votre plateforme de gestion scolaire.
                </p>
            </div>

            <div class="auth-benefits">
                <div class="auth-benefit">
                    <span>
                        <i class="fas fa-user-plus"></i>
                    </span>
                    <div>
                        <strong>Création de compte</strong>
                        <p>Un accès simple à votre espace personnel.</p>
                    </div>
                </div>

                <div class="auth-benefit">
                    <span>
                        <i class="fas fa-shield-alt"></i>
                    </span>
                    <div>
                        <strong>Données protégées</strong>
                        <p>Vos informations restent confidentielles.</p>
                    </div>
                </div>

                <div class="auth-benefit">
                    <span>
                        <i class="fas fa-graduation-cap"></i>
                    </span>
                    <div>
                        <strong>Gestion scolaire</strong>
                        <p>Une plateforme dédiée à votre établissement.</p>
                    </div>
                </div>
            </div>

            <p class="auth-slogan">
                Ensemble pour l'excellence.
            </p>
        </section>

        {{-- Formulaire d'inscription --}}
        <section class="auth-form-panel">
            <div class="auth-form-content">

                <div class="auth-mobile-brand">
                    <i class="fas fa-school"></i> School
                </div>

                <div class="auth-heading">
                    <h2>Créer un compte</h2>
                    <p>Renseignez vos informations pour continuer.</p>
                </div>

                {{-- Erreurs de validation --}}
                @if ($errors->any())
                    <div class="auth-register-errors" role="alert">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Veuillez corriger les erreurs suivantes.

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nom complet --}}
                    <div class="auth-field">
                        <label for="name">Nom complet</label>

                        <div class="auth-input-wrap">
                            <i class="far fa-user"></i>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Votre nom complet"
                                autocomplete="name"
                                required
                                autofocus
                            >
                        </div>

                        @error('name')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Adresse e-mail --}}
                    <div class="auth-field">
                        <label for="email">Adresse e-mail</label>

                        <div class="auth-input-wrap">
                            <i class="far fa-envelope"></i>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="exemple@ecole.tg"
                                autocomplete="username"
                                required
                            >
                        </div>

                        @error('email')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Mot de passe --}}
                    <div class="auth-field">
                        <label for="password">Mot de passe</label>

                        <div class="auth-input-wrap">
                            <i class="fas fa-lock"></i>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Au moins 8 caractères"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >

                            <button
                                type="button"
                                class="auth-password-toggle"
                                data-toggle-password="password"
                                aria-label="Afficher le mot de passe"
                            >
                                <i class="far fa-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmation du mot de passe --}}
                    <div class="auth-field">
                        <label for="password_confirmation">
                            Confirmer le mot de passe
                        </label>

                        <div class="auth-input-wrap">
                            <i class="fas fa-lock"></i>

                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Répétez votre mot de passe"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >

                            <button
                                type="button"
                                class="auth-password-toggle"
                                data-toggle-password="password_confirmation"
                                aria-label="Afficher la confirmation"
                            >
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Bouton de création --}}
                    <button type="submit" class="auth-submit">
                        <i class="fas fa-user-plus me-2"></i>
                        Créer mon compte
                    </button>
                </form>

                <div class="auth-help auth-register-footer">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}">Se connecter</a>
                </div>
            </div>

            <div class="auth-bottom">
                <i class="fas fa-lock me-1"></i>
                Inscription sécurisée à votre établissement
            </div>
        </section>
    </div>

    {{-- Afficher / masquer les mots de passe --}}
    <script>
        document.querySelectorAll('[data-toggle-password]')
            .forEach(function (button) {
                button.addEventListener('click', function () {
                    const input = document.getElementById(
                        button.dataset.togglePassword
                    );

                    const icon = button.querySelector('i');
                    const hidden = input.type === 'password';

                    input.type = hidden ? 'text' : 'password';

                    icon.classList.toggle('fa-eye', !hidden);
                    icon.classList.toggle('fa-eye-slash', hidden);

                    button.setAttribute(
                        'aria-label',
                        hidden
                            ? 'Masquer le mot de passe'
                            : 'Afficher le mot de passe'
                    );
                });
            });
    </script>


</body>
</html>
