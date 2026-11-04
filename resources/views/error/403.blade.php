<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light px-3">
    <div class="text-center">
        <div class="mb-4">
            <i class="bi bi-shield-lock text-danger" style="font-size: 75px;"></i>
        </div>

        <h1 class="display-1 fw-bold text-danger">403</h1>

        <h2 class="fw-bold mb-3">Accès refusé</h2>

        <p class="text-muted mb-4">
            Désolé, vous n'avez pas les autorisations nécessaires
            pour accéder à cette page.
            Veuillez contacter l'administrateur si vous pensez qu'il s'agit d'une erreur.
        </p>

        <a href="{{ url('/') }}" class="btn btn-danger px-4 py-2">
            <i class="bi bi-house-door me-2"></i>
            Retour à l'accueil
        </a>

        <div class="mt-4 text-muted small">
            School Gestion Scolaire
        </div>
    </div>
</div>
</body>
</html>