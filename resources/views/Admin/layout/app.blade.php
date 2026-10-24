<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')Food App</title>
    {{-- icon bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('assets/admin/css/styles.css') }}" rel="stylesheet" />

    <!-- FontAwesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    {{-- navbar --}}
    @include('Admin.layout.inc.navbar')

    <div id="layoutSidenav">
        {{-- sidebar --}}
        @include('Admin.layout.inc.sideBar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4" id="mainContent">
                    {{-- content --}}
                    @yield('content')
                </div>
            </main>
            <!-- Conteneur global pour les toasts -->
        </div>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('schoolSidebar');
            const toggle = document.getElementById('sidebarToggle');

            if (sidebar && toggle) {
                toggle.addEventListener('click', function () {
                    sidebar.classList.toggle('show');
                });

                document.addEventListener('click', function (event) {
                    if (
                        window.innerWidth < 992 &&
                        sidebar.classList.contains('show') &&
                        !sidebar.contains(event.target) &&
                        !toggle.contains(event.target)
                    ) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>

    <style>
        .school-main {
    min-width: 0;
    margin-left: 260px;
}

.school-content {
    min-height: calc(100vh - 76px);
}

@media (max-width: 991.98px) {
    .school-main {
        margin-left: 0;
    }
}
:root {
    --school-sidebar: #102747;
    --school-sidebar-hover: #1c3b64;
    --school-primary: #2475ed;
    --school-text: #253858;
    --school-muted: #8794a8;
    --school-border: #edf0f5;
    --school-bg: #f5f7fb;
}

body {
    background: var(--school-bg);
    color: var(--school-text);
    font-family: "Inter", "Segoe UI", sans-serif;
}

.school-sidebar {
    position: fixed;
    inset: 0 auto 0 0;
    z-index: 1040;
    display: flex;
    flex-direction: column;
    width: 260px;
    height: 100dvh;
    overflow-y: auto;
    background: var(--school-sidebar);
    color: #fff;
    transition: transform .25s ease;
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 82px;
    padding: 20px;
    border-bottom: 1px solid rgba(255,255,255,.08);
}

.brand-icon,
.footer-school-icon {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: var(--school-primary);
    color: white;
    font-size: 19px;
}

.brand-text,
.profile-info,
.sidebar-footer > div:last-child {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.brand-text strong {
    font-size: 21px;
    letter-spacing: -.5px;
}

.brand-text small,
.profile-info small,
.sidebar-footer small {
    color: #a9bbd4;
    font-size: 11px;
}

.sidebar-profile {
    display: flex;
    align-items: center;
    gap: 11px;
    margin: 18px 14px 10px;
    padding: 13px;
    border-radius: 12px;
    background: rgba(255,255,255,.06);
}

.profile-avatar,
.navbar-avatar {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #dceaff;
    color: #185fc4;
    font-weight: 700;
}

.profile-info strong,
.sidebar-footer strong {
    overflow: hidden;
    color: #fff;
    font-size: 12px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.sidebar-navigation {
    flex: 1;
    padding: 8px 12px 18px;
}

.sidebar-group {
    margin-bottom: 23px;
}

.sidebar-group-title {
    padding: 8px 10px 10px;
    color: #8fa6c5;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.1px;
}

.sidebar-link {
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 43px;
    margin: 3px 0;
    padding: 11px 13px;
    border-radius: 9px;
    color: #c8d5e7;
    font-size: 13px;
    text-decoration: none;
    transition: background .2s, color .2s;
}

.sidebar-link i {
    width: 19px;
    text-align: center;
    font-size: 15px;
}

.sidebar-link:hover {
    background: var(--school-sidebar-hover);
    color: white;
}

.sidebar-link.active {
    background: var(--school-primary);
    color: white;
    box-shadow: 0 5px 14px rgba(0, 80, 200, .2);
}

.active-indicator {
    width: 5px;
    height: 5px;
    margin-left: auto;
    border-radius: 50%;
    background: white;
}

.sidebar-footer {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 12px;
    padding: 14px 8px;
    border-top: 1px solid rgba(255,255,255,.1);
}

.footer-school-icon {
    width: 35px;
    height: 35px;
    font-size: 15px;
}

.sidebar-footer small {
    margin-top: 4px;
    font-size: 10px;
}

.school-navbar {
    position: sticky;
    top: 0;
    z-index: 1020;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 76px;
    margin-left: 260px;
    padding: 12px 28px;
    border-bottom: 1px solid var(--school-border);
    background: rgba(255,255,255,.96);
    backdrop-filter: blur(12px);
}

.navbar-left,
.navbar-right {
    display: flex;
    align-items: center;
    gap: 18px;
}

.sidebar-toggle,
.navbar-icon-btn {
    position: relative;
    display: grid;
    place-items: center;
    width: 40px;
    height: 40px;
    border: 1px solid var(--school-border);
    border-radius: 10px;
    background: white;
    color: #50617a;
    cursor: pointer;
}

.sidebar-toggle:hover,
.navbar-icon-btn:hover {
    background: #f2f6ff;
    color: var(--school-primary);
}

.navbar-heading,
.navbar-user-info {
    display: flex;
    flex-direction: column;
}

.navbar-heading strong,
.navbar-user-info strong {
    color: #243650;
    font-size: 13px;
}

.navbar-heading small,
.navbar-user-info small {
    margin-top: 3px;
    color: var(--school-muted);
    font-size: 11px;
}

.notification-dot {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 7px;
    height: 7px;
    border: 1px solid white;
    border-radius: 50%;
    background: #f04452;
}

.user-dropdown {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 3px 0 3px 8px;
    border: 0;
    background: transparent;
}

.user-dropdown::after {
    margin-left: 3px;
}

.navbar-avatar {
    width: 37px;
    height: 37px;
}

@media (max-width: 991.98px) {
    .school-sidebar {
        transform: translateX(-100%);
        box-shadow: 8px 0 30px rgba(10,30,60,.12);
    }

    .school-sidebar.show {
        transform: translateX(0);
    }

    .school-navbar {
        margin-left: 0;
        padding: 12px 16px;
    }
}

@media (max-width: 575.98px) {
    .navbar-heading,
    .navbar-user-info {
        display: none;
    }

    .navbar-left,
    .navbar-right {
        gap: 10px;
    }

    .school-navbar {
        min-height: 66px;
    }
}
</style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="{{ asset('assets/admin/js/datatables-simple-demo.js') }}"></script>
    <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;"></div>
    <script src="https://js.pusher.com/8.4/pusher.min.js"></script>
    <script>
        // Initialisation Pusher
        var pusher = new Pusher('206ab0f95707bdd8d1b4', {
            cluster: 'eu',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        // Fonction toast Bootstrap
        function showToast(title, message) {
            const toastId = 'toast-' + Date.now();
            const toastHtml = `
        <div id="${toastId}" class="toast align-items-center text-bg-primary border-0 mb-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}</strong><br>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
            </div>
        </div>`;
            const container = document.querySelector('.toast-container');
            if (container) {
                container.insertAdjacentHTML('beforeend', toastHtml);
                const toastElement = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastElement, {
                    delay: 5000
                });
                toast.show();
            }
        }

        // --- Admin ---
        @if (auth()->check() && auth()->user()->is_admin)
            var adminChannel = pusher.subscribe('private-admin.notifications');
            adminChannel.bind('notification', function(data) {
                showToast('Notification Admin', data.message);
            });
        @endif
    </script>






    <!-- SweetAlert2 -->

    <script>
        setTimeout(() => {
            $('#alert-message').fadeOut('slow');
        }, 4000);


        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Empêche la soumission directe

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Soumet le formulaire si confirmé
                    }
                });
            });
        });

        document.querySelectorAll('.delete-category-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Empêche la soumission directe

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action supprimera définitivement cette catégorie !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Soumet le formulaire si confirmé
                    }
                });
            });
        });
    </script>
    @yield('scripts');

<script>


    
document.getElementById('sidebarToggle')?.addEventListener('click', function () {
    document.body.classList.toggle('sb-sidenav-toggled');
});
</script>

<script>
document.getElementById('eleves_id').addEventListener('change', function () {
    const niveau = this.options[this.selectedIndex].dataset.niveau;
    const periodeSelect = document.getElementById('periode_id');

    [...periodeSelect.options].forEach(option => {
        if (!option.dataset.type) return;

        if (niveau === 'college') {
            option.hidden = option.dataset.type !== 'trimestre';
        } else if (niveau === 'lycee') {
            option.hidden = option.dataset.type !== 'semestre';
        }
    });

    periodeSelect.value = '';
});
</script>

</body>

</html>
