 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Accès interdit</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            background: #111827;
            color: #fff;
            padding: 20px;
        }

        .error-container {
            width: 100%;
            max-width: 650px;
            text-align: center;
            padding: 50px 35px;
            background: #1f2937;
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 24px;
            box-shadow: 0 25px 70px rgba(0,0,0,.3);
        }

        .icon-container {
            width: 110px;
            height: 110px;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(239,68,68,.12);
            border-radius: 50%;
            color: #ef4444;
            font-size: 48px;
        }

        .error-code {
            font-size: 100px;
            line-height: 1;
            font-weight: 800;
            color: #ef4444;
            letter-spacing: -5px;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            margin: 20px 0 12px;
        }

        .error-message {
            color: #9ca3af;
            font-size: 15px;
            line-height: 1.8;
            max-width: 450px;
            margin: 0 auto 30px;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 25px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-home:hover {
            background: #1d4ed8;
            color: white;
            transform: translateY(-3px);
        }

        .footer-text {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,.08);
            color: #6b7280;
            font-size: 12px;
        }

        @media(max-width: 576px) {
            .error-container {
                padding: 40px 20px;
            }

            .error-code {
                font-size: 75px;
            }

            .error-title {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

    <div class="error-container">

        <div class="icon-container">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div class="error-code">403</div>

        <h1 class="error-title">Accès refusé !</h1>

        <p class="error-message">
            Désolé, vous n'avez pas les autorisations nécessaires
            pour accéder à cette page.
            Veuillez contacter l'administrateur si vous pensez
            qu'il s'agit d'une erreur.
        </p>

        <a href="{{ url('/') }}" class="btn-home">
            <i class="bi bi-house-door-fill"></i>
            Retour à l'accueil
        </a>

        <div class="footer-text">
            <i class="bi bi-mortarboard-fill me-1"></i>
            SCHOOL GESTION SCOLAIRE
            <br>
            © {{ date('Y') }} - Tous droits réservés
        </div>

    </div>

</body>
</html>