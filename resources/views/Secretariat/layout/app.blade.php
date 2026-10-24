<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Espace Parent')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.v.5/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/js/bootstrap.v.5.3.2/bootstrap.bundle.min.js') }}">

    {{-- Custom styles --}}
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #0d6efd;
        }

        body {
            background-color: #f8fafc;
            transition: background-color .3s ease, color .3s ease;
        }

        /* ===== SIDEBAR ===== */
        .parent-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #0d6efd, #0b5ed7);
            padding-top: 1rem;
            transition: transform .3s ease;
            z-index: 1040;
        }

        .sidebar-header {
            padding: 1rem;
            text-align: center;
            color: #fff;
        }

        .parent-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,.85);
            padding: 10px 16px;
            border-radius: 8px;
            margin: 4px 12px;
            transition: all .2s ease;
        }

        .parent-sidebar .nav-link:hover {
            background-color: rgba(255,255,255,.15);
            transform: translateX(4px);
            color: #fff;
        }

        .parent-sidebar .nav-link.active {
            background-color: #fff;
            color: var(--primary);
            font-weight: 600;
        }

        /* ===== NAVBAR ===== */
        .parent-navbar {
            height: 64px;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 1030;
            transition: left .3s ease;
        }

        /* ===== CONTENT ===== */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            padding: 90px 24px 24px;
            transition: margin-left .3s ease;
        }

        /* ===== DARK MODE ===== */
        body.dark {
            background-color: #0f172a;
            color: #e5e7eb;
        }

        body.dark .parent-sidebar {
            background: linear-gradient(180deg, #020617, #020617);
        }

        body.dark .navbar,
        body.dark .dropdown-menu,
        body.dark .card,
        body.dark footer {
            background-color: #1e293b !important;
            color: #e5e7eb;
        }

        body.dark .nav-link,
        body.dark .dropdown-item {
            color: #e5e7eb;
        }

        body.dark .dropdown-item:hover {
            background-color: #334155;
        }

        /* ===== MOBILE ===== */
        @media (max-width: 992px) {
            .parent-sidebar {
                transform: translateX(-100%);
            }

            .parent-sidebar.show {
                transform: translateX(0);
            }

            .parent-navbar {
                left: 0;
            }

            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
    <script>
function markAsRead(notificationId) {
    fetch('/parent/notifications/' + notificationId + '/read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
    }).then(res => {
        // Optionnel : rafraîchir le badge ou le style
        document.location.reload();
    });
}
</script>

</head>
<body>

{{-- SIDEBAR --}}
@include('secretariat.layout.inc.sidebar')

{{-- NAVBAR --}}
@include('secretariat.layout.inc.navbar')

{{-- CONTENT --}}
<main class="content-wrapper">
    @yield('content')
</main>

{{-- FOOTER --}}
@include('secretariat.layout.inc.footer')

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar toggle (mobile)
    document.getElementById('toggleSidebar')?.addEventListener('click', () => {
        document.querySelector('.parent-sidebar').classList.toggle('show');
    });

    // Dark mode (persistant)
    const darkToggle = document.getElementById('darkToggle');
    if (localStorage.getItem('dark') === 'true') {
        document.body.classList.add('dark');
    }

    darkToggle?.addEventListener('click', () => {
        document.body.classList.toggle('dark');
        localStorage.setItem('dark', document.body.classList.contains('dark'));
    });
</script>

@stack('scripts')
</body>
</html>
