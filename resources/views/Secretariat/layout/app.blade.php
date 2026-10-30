
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Secrétariat') | School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          rel="stylesheet">
          <link rel="stylesheet" href="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.min.css') }}">
          <link rel="stylesheet" href="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.bundle.min.js') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/secretariat.css') }}">
</head>
<body class="secretariat-body">

    @include('secretariat.layout.inc.sidebar')

    <div class="secretariat-main" id="secretariatMain">
        @include('secretariat.layout.inc.navbar')

        <main class="secretariat-content">
            @yield('content')
        </main>

        @include('secretariat.layout.inc.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const toggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('secretariatSidebar');

        toggle?.addEventListener('click', function () {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-open');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
            }
        });

        document.addEventListener('click', function (event) {
            if (
                window.innerWidth <= 768 &&
                sidebar &&
                !sidebar.contains(event.target) &&
                !toggle.contains(event.target)
            ) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
