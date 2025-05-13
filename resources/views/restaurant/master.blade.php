<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Restaurant</title>
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
        }

        .logout-btn:hover {
            background-color: var(--accent-color);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: -var(--sidebar-width);
                z-index: 1000;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Barre de navigation latérale -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                Restaurant Dashboard
            </div>
            <ul class="nav-menu">
                <li class="nav-item {{ Route::currentRouteName() == 'restaurant.dashboard' ? 'active' : '' }}" onclick="location.href='{{ route('restaurant.dashboard') }}'">
                    <span class="nav-icon"><i class="fas fa-dashboard"></i></span>
                    Tableau de Bord
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'restaurant.profile' ? 'active' : '' }}" onclick="location.href='{{ route('restaurant.profile') }}'">
                    <span class="nav-icon"><i class="fas fa-user"></i></span>
                    Mon Profil
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'restaurant.menus.index' ? 'active' : '' }}" onclick="location.href='{{ route('restaurant.menus.index') }}'">
                    <span class="nav-icon">🍽️</span>
                    Gestion des Menus
                </li>
                <li class="nav-item nav-item-with-submenu {{ in_array(Route::currentRouteName(), ['restaurant.tables', 'restaurant.table.create']) ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-list"></i></span>
                    Tables
                    <ul class="submenu">
                        <li class="submenu-item {{ Route::currentRouteName() == 'restaurant.tables' ? 'active' : '' }}" onclick="location.href='{{ route('restaurant.tables') }}'">
                            Tous les Tables
                        </li>
                        <li class="submenu-item {{ Route::currentRouteName() == 'restaurant.table.create' ? 'active' : '' }}" onclick="location.href='{{ route('restaurant.table.create') }}'">
                            Ajouter une Table
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'restaurant.reservations' ? 'active' : '' }}" onclick="location.href='{{ route('restaurant.reservations') }}'">
                    <span class="nav-icon"><i class="fas fa-list"></i></span>
                    Réservations
                </li>
            </ul>

            <!-- Bouton de déconnexion -->
            <button class="logout-btn" onclick="location.href='{{ route('restaurant.logout') }}'">
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
                    <span>{{ Auth::guard('restaurant')->user()->name }}</span>
                </div>
            </header>

            <!-- Contenu de la page -->
            <div class="page-wrapper">
                @yield('restaurant')
            </div>
        </main>
    </div>

    <script>
        // Script pour les sous-menus
        document.querySelectorAll('.nav-item-with-submenu').forEach(item => {
            item.addEventListener('click', function(e) {
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
        document.addEventListener('DOMContentLoaded', function() {
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