 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Page introuvable</title>
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light px-3">
    <div class="text-center">
        <div class="mb-4">
            <i class="bi bi-search text-primary" style="font-size: 75px;"></i>
        </div>

        <h1 class="display-1 fw-bold text-primary">404</h1>

        <h2 class="fw-bold mb-3">Oups ! Page introuvable</h2>

        <p class="text-muted mb-4">
            La page que vous recherchez n'existe pas,
            a été déplacée ou son adresse est incorrecte.
        </p>

        <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2">
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



