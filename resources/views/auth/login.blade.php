<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/Auth/css/sytle.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

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
                <h1>Bienvenue !</h1>
                <p>
                    Connectez-vous à votre espace pour gérer
                    efficacement votre établissement.
                </p>
            </div>

            <div class="auth-benefits">
                <div class="auth-benefit">
                    <span><i class="fas fa-shield-alt"></i></span>
                    <div>
                        <strong>Gestion simplifiée</strong>
                        <p>Élèves, enseignants, classes et bulletins.</p>
                    </div>
                </div>

                <div class="auth-benefit">
                    <span><i class="fas fa-chart-line"></i></span>
                    <div>
                        <strong>Suivi en temps réel</strong>
                        <p>Des informations centralisées.</p>
                    </div>
                </div>

                <div class="auth-benefit">
                    <span><i class="fas fa-graduation-cap"></i></span>
                    <div>
                        <strong>Un meilleur avenir</strong>
                        <p>Pour une éducation de qualité.</p>
                    </div>
                </div>
            </div>

            <p class="auth-slogan">Ensemble pour l'excellence.</p>
        </section>

        {{-- Formulaire de connexion --}}
        <section class="auth-form-panel">
            <div class="auth-form-content">
                <div class="auth-mobile-brand">
                    <i class="fas fa-school"></i> School
                </div>

                <div class="auth-heading">
                    <h2>Connexion</h2>
                    <p>Accédez à votre tableau de bord.</p>
                </div>

                <x-auth-session-status
                    class="auth-status"
                    :status="session('status')"
                />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

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
                                autofocus
                            >
                        </div>

                        @error('email')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="password">Mot de passe</label>

                        <div class="auth-input-wrap">
                            <i class="fas fa-lock"></i>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Votre mot de passe"
                                autocomplete="current-password"
                                required
                            >

                            <button type="button"
                                    class="auth-password-toggle"
                                    data-toggle-password="password"
                                    aria-label="Afficher le mot de passe">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-options">
                        <label class="auth-checkbox">
                            <input type="checkbox" name="remember">
                            <span>Se souvenir de moi</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="auth-submit">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Se connecter
                    </button>
                </form>

                <div class="auth-help">
                    <i class="fas fa-info-circle me-1"></i>
                    Vous n'avez pas de compte ?
                    <span>Contactez l'administration.</span>
                </div>
            </div>

            <div class="auth-bottom">
                <i class="fas fa-lock me-1"></i>
                Connexion sécurisée à votre établissement
            </div>
        </section>
    </div>

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
                        hidden ? 'Masquer le mot de passe'
                               : 'Afficher le mot de passe'
                    );
                });
            });
    </script>

</body>
</html>