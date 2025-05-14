<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resto - Admin Dashboard</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset et variables */
        :root {
            --primary-color: #10b981;
            /* Emerald Green */
            --primary-color-light: #6ee7b7;
            /* Lighter green */
            --bg-color: #f0fdf4;
            /* Very light green background */
            --text-dark: #064e3b;
            /* Dark green for text */
            --text-light: #065f46;
            /* Slightly lighter dark green */
            --accent-color: #047857;
            /* Accent green */
            --border-color: #6ee7b7;
            /* Light green border */
            --sidebar-width: 250px;
            /* Largeur de la sidebar */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Layout principal */
        .dashboard-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Barre de navigation latérale */
        .sidebar {
            width: var(--sidebar-width);
            background-color: white;
            border-right: 1px solid var(--border-color);
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .sidebar-logo img {
            max-width: 100%;
            height: auto;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: var(--primary-color-light);
            color: var(--text-dark);
        }

        .nav-icon {
            margin-right: 1rem;
            width: 1.25rem;
            height: 1.25rem;
            opacity: 0.7;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .nav-item.active .nav-icon {
            opacity: 1;
        }

        /* Sous-menu */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 2rem;
        }

        .nav-item-with-submenu.active .submenu {
            max-height: 200px;
        }

        .submenu-item {
            padding: 0.5rem 1rem;
            color: var(--text-light);
            text-decoration: none;
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .submenu-item:hover,
        .submenu-item.active {
            color: var(--accent-color);
        }

        /* Contenu principal */
        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 2rem;
            background-color: var(--bg-color);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 0.5rem 1rem;
            width: 300px;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex-grow: 1;
            margin-left: 0.5rem;
            color: var(--text-dark);
        }

        .search-bar i {
            color: var(--primary-color);
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background-color: var(--primary-color-light);
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-dark);
        }

        /* Grille de statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.1);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            transition: transform 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 8px -2px rgba(6, 78, 59, 0.2);
        }

        .stat-icon {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stat-trend {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
        }

        .trend-positive {
            color: #10b981;
            /* Green for positive trends */
        }

        .trend-negative {
            color: #ef4444;
            /* Red for negative trends */
        }

        /* Content Container */
        .content-container {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.1);
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .content-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 0.75rem 1rem;
            text-align: left;
        }

        table th {
            background-color: var(--bg-color);
            color: var(--text-dark);
            font-weight: 600;
        }

        table tr {
            border-bottom: 1px solid var(--border-color);
        }

        table tr:last-child {
            border-bottom: none;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: var(--text-dark);
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        /* Footer */
        .footer {
            margin-top: auto;
            text-align: center;
            padding: 1rem 0;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        /* Logout Button */
        .logout-btn {
            margin-top: auto;
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .logout-btn:hover {
            background-color: var(--accent-color);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background-color: white;
            border-radius: 0.75rem;
            width: 100%;
            max-width: 500px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .modal-close {
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--text-light);
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: var(--text-dark);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.25rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: -100%;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .mobile-menu-toggle {
                display: flex;
                cursor: pointer;
                font-size: 1.5rem;
                color: var(--text-dark);
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .search-bar {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Barre de navigation latérale -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                Admin Dashboard
            </div>
            <ul class="nav-menu">
                <li class="nav-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}"
                    onclick="location.href='{{ route('admin.dashboard') }}'">
                    <span class="nav-icon"><i class="fas fa-tachometer-alt"></i></span>
                    Dashboard
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'admin.profile' ? 'active' : '' }}"
                    onclick="location.href='{{ route('admin.profile') }}'">
                    <span class="nav-icon"><i class="fas fa-user"></i></span>
                    Mon Profil
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'Admin.restaurants' ? 'active' : '' }}"
                    onclick="location.href='{{ route('Admin.restaurants') }}'">
                    <span class="nav-icon"><i class="fas fa-utensils"></i></span>
                    Restaurants
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'Admin.clients' ? 'active' : '' }}"
                    onclick="location.href='{{ route('Admin.clients') }}'">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    Clients
                </li>
            </ul>

            <!-- Bouton de déconnexion -->
            <button class="logout-btn" onclick="document.getElementById('logoutModal').classList.add('active')">
                <i class="fas fa-sign-out-alt"></i> Se déconnecter
            </button>
        </aside>

        <!-- Contenu principal -->
        <main class="main-content">
            <!-- En-tête -->
            <header class="header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher...">
                </div>
                <div class="user-section">
                    <div class="user-avatar"><i class="fas fa-user"></i></div>
                    <span>{{ Auth::guard('admin')->user()->name }}</span>
                </div>
            </header>
            <!-- Contenu de la page -->
            <div class="page-wrapper">
                @yield('admin')
            </div>

            <!-- Footer -->
            <div class="footer">
                <small>Copyright © RESTO 2025</small>
            </div>
        </main>
    </div>

    <!-- Modal de déconnexion -->
    <div class="modal-overlay" id="logoutModal">
        <div class="modal">
            <div class="modal-header">
                <h5 class="modal-title">Prêt à partir?</h5>
                <span class="modal-close"
                    onclick="document.getElementById('logoutModal').classList.remove('active')">&times;</span>
            </div>
            <div class="modal-body">
                Sélectionnez "SE DÉCONNECTER" ci-dessous si vous êtes prêt à mettre fin à votre session en cours.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary"
                    onclick="document.getElementById('logoutModal').classList.remove('active')">ANNULER</button>
                <a class="btn btn-primary" href="{{ route('admin.logout') }}">SE DÉCONNECTER</a>
            </div>
        </div>
    </div>

    <script>
        // Script pour les sous-menus
        document.querySelectorAll('.nav-item-with-submenu').forEach(item => {
            item.addEventListener('click', function (e) {
                // Empêcher la propagation si on clique directement sur l'élément parent
                if (e.target === this || e.target.parentNode === this) {
                    e.preventDefault();
                    this.classList.toggle('active');

                    // Afficher automatiquement le sous-menu si un de ses éléments est actif
                    const hasActiveSubmenu = Array.from(this.querySelectorAll('.submenu-item')).some(
                        subItem => subItem.classList.contains('active')
                    );

                    if (hasActiveSubmenu && !this.classList.contains('active')) {
                        this.classList.add('active');
                    }
                }
            });
        });

        // Ouvrir automatiquement le sous-menu si un élément est actif au chargement
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.nav-item-with-submenu').forEach(item => {
                const hasActiveSubmenu = Array.from(item.querySelectorAll('.submenu-item')).some(
                    subItem => subItem.classList.contains('active')
                );

                if (hasActiveSubmenu) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>