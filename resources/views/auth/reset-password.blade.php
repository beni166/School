<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/Auth/css/style.css') }}">
    <title>Document</title>
</head>
<body>
    
    <div class="auth-reset-shell">
        <div class="auth-reset-brand">
            <span class="auth-brand-icon">
                <i class="fas fa-school"></i>
            </span>
            <div>
                <strong>School</strong>
                <small>Gestion scolaire</small>
            </div>
        </div>

        <div class="auth-reset-icon">
            <i class="fas fa-lock"></i>
        </div>

        <h1>Nouveau mot de passe</h1>

        <p class="auth-reset-description">
            Choisissez un nouveau mot de passe pour sécuriser
            votre compte.
        </p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="auth-field">
                <label for="email">Adresse e-mail</label>

                <div class="auth-input-wrap">
                    <i class="far fa-envelope"></i>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        autocomplete="username"
                        required
                    >
                </div>

                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password">Nouveau mot de passe</label>

                <div class="auth-input-wrap">
                    <i class="fas fa-lock"></i>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="Nouveau mot de passe"
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
                        autocomplete="new-password"
                        placeholder="Confirmez le mot de passe"
                        required
                    >

                    <button type="button"
                            class="auth-password-toggle"
                            data-toggle-password="password_confirmation"
                            aria-label="Afficher le mot de passe">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="auth-submit">
                <i class="fas fa-check-circle me-2"></i>
                Réinitialiser le mot de passe
            </button>
        </form>

        <a href="{{ route('login') }}" class="auth-back-link">
            <i class="fas fa-arrow-left me-2"></i>
            Retour à la connexion
        </a>
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
                });
            });
    </script>

</body>
</html>