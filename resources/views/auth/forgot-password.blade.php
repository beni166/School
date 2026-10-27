<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/Auth/css/sytle.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            <i class="fas fa-envelope-open-text"></i>
        </div>

        <h1>Mot de passe oublié ?</h1>

        <p class="auth-reset-description">
            Pas d'inquiétude. Indiquez l'adresse e-mail associée
            à votre compte. Nous vous enverrons un lien pour
            réinitialiser votre mot de passe.
        </p>

        <x-auth-session-status
            class="auth-status"
            :status="session('status')"
        />

        <form method="POST" action="{{ route('password.email') }}">
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

            <button type="submit" class="auth-submit">
                <i class="fas fa-paper-plane me-2"></i>
                Envoyer le lien
            </button>
        </form>

        <a href="{{ route('login') }}" class="auth-back-link">
            <i class="fas fa-arrow-left me-2"></i>
            Retour à la connexion
        </a>
    </div>
</body>
</html>