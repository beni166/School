<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | École Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eef4ff, #f8faff);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
        }

        .register-card {
            width: 100%;
            max-width: 460px;
            background: #fff;
            border: 1px solid #e8edf5;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 15px 45px rgba(31, 55, 90, .09);
        }

        .school-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf1ff;
            color: #2457d6;
            border-radius: 18px;
            font-size: 30px;
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 10px;
        }

        .input-group-text {
            background: #fff;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .form-control:focus {
            border-color: #2457d6;
            box-shadow: 0 0 0 .2rem rgba(36, 87, 214, .12);
        }

        .btn-register {
            background: #2457d6;
            border: none;
            color: #fff;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-register:hover {
            background: #1945b5;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="register-card">

    <div class="text-center mb-4">
        <div class="school-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>

        <h3 class="fw-bold mb-2">Créer un compte</h3>
        <p class="text-secondary mb-0">
            Rejoignez votre espace de gestion scolaire
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle me-2"></i>
            Veuillez corriger les erreurs du formulaire.
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nom --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">
                Nom complet
            </label>

            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person text-secondary"></i>
                </span>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Votre nom complet"
                    required
                    autofocus
                    autocomplete="name"
                >
            </div>

            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- E-mail --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">
                Adresse e-mail
            </label>

            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope text-secondary"></i>
                </span>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="nom@exemple.com"
                    required
                    autocomplete="username"
                >
            </div>

            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mot de passe --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">
                Mot de passe
            </label>

            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock text-secondary"></i>
                </span>

                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Créer un mot de passe"
                    required
                    autocomplete="new-password"
                >
            </div>

            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirmation --}}
        <div class="mb-4">
            <label for="password_confirmation"
                   class="form-label fw-semibold">
                Confirmer le mot de passe
            </label>

            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-shield-lock text-secondary"></i>
                </span>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Répéter le mot de passe"
                    required
                    autocomplete="new-password"
                >
            </div>
        </div>

        <button type="submit" class="btn btn-register w-100">
            <i class="bi bi-person-plus me-2"></i>
            Créer mon compte
        </button>
    </form>

    <div class="text-center mt-4">
        <span class="text-secondary small">
            Vous avez déjà un compte ?
        </span>

        <a href="{{ route('login') }}"
           class="small fw-semibold text-decoration-none">
            Se connecter
        </a>
    </div>

    <div class="text-center mt-4">
        <small class="text-secondary">
            &copy; {{ date('Y') }} École Admin — Gestion scolaire
        </small>
    </div>

</div>

</body>
</html>
