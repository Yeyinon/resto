@extends('admin.master')
@section('admin')
    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <span class="stat-label">Restaurants</span>
            <div class="stat-value">{{ $nbr_resto }}</div>
            <div class="stat-trend {{ $resto_trend_percentage >= 0 ? 'trend-positive' : 'trend-negative' }}">
                <i class="fas fa-arrow-{{ $resto_trend_percentage >= 0 ? 'up' : 'down' }}"></i> {{ $resto_trend_percentage > 0 ? '+' : '' }}{{ $resto_trend_percentage }}% cette semaine
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <span class="stat-label">Clients</span>
            <div class="stat-value">{{ $nbr_client }}</div>
            <div class="stat-trend {{ $client_trend_percentage >= 0 ? 'trend-positive' : 'trend-negative' }}">
                <i class="fas fa-arrow-{{ $client_trend_percentage >= 0 ? 'up' : 'down' }}"></i> {{ $client_trend_percentage > 0 ? '+' : '' }}{{ $client_trend_percentage }}% ce mois
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <span class="stat-label">Réservations</span>
            <div class="stat-value">{{ $reservations_total }}</div>
            <div class="stat-trend {{ $reservation_trend_percentage >= 0 ? 'trend-positive' : 'trend-negative' }}">
                <i class="fas fa-arrow-{{ $reservation_trend_percentage >= 0 ? 'up' : 'down' }}"></i> {{ $reservation_trend_percentage > 0 ? '+' : '' }}{{ $reservation_trend_percentage }}% cette semaine
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <span class="stat-label">Note moyenne</span>
            <div class="stat-value">{{ number_format($rating_avg, 1) }}</div>
            <div class="stat-trend {{ $rating_trend >= 0 ? 'trend-positive' : 'trend-negative' }}">
                <i class="fas fa-arrow-{{ $rating_trend >= 0 ? 'up' : 'down' }}"></i> {{ $rating_trend > 0 ? '+' : '' }}{{ number_format($rating_trend, 1) }} ce mois
            </div>
        </div>
    </div>



    <!-- Graphique des réservations par restaurant -->
    <div class="content-container">
        <h2 class="content-title">
            <i class="fas fa-chart-bar"></i> Nombre de réservations par restaurant
        </h2>
        <div class="chart-container" style="position: relative; height: 400px;">
            <div class="chart-scroll-controls">
                <button id="scrollLeft" class="chart-scroll-btn chart-scroll-left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="scrollRight" class="chart-scroll-btn chart-scroll-right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="chart-wrapper" style="overflow-x: hidden; position: relative; height: 400px;">
                <canvas id="reservationsChart"></canvas>
            </div>
        </div>
    </div>



    <!-- Script pour le graphique -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Données pour le graphique
            const restaurants = @json($restaurants->pluck('name'));
            const reservations = @json($restaurants->pluck('reservationCount'));
            
            // Configuration et création du graphique
            const ctx = document.getElementById('reservationsChart').getContext('2d');
            let reservationsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: restaurants,
                    datasets: [{
                        label: 'Nombre de réservations',
                        data: reservations,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgb(10, 145, 100)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(6, 78, 59, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(6, 78, 59, 0.8)',
                            padding: 10,
                            cornerRadius: 6,
                            displayColors: false
                        }
                    }
                }
            });
            
            // Configuration du défilement
            const totalItems = restaurants.length;
            const initialVisibleItems = calculateVisibleItems();
            let startIndex = 0;
            let visibleItems = initialVisibleItems;
            
            // Fonctions pour le défilement
            function calculateVisibleItems() {
                // Calcul approximatif basé sur la largeur de l'écran
                const containerWidth = document.querySelector('.chart-wrapper').offsetWidth;
                // Supposons qu'un restaurant prend environ 100px de largeur
                return Math.max(5, Math.floor(containerWidth / 100));
            }
            
            function updateChart() {
                // Mise à jour du graphique avec les restaurants visibles
                const visibleLabels = restaurants.slice(startIndex, startIndex + visibleItems);
                const visibleData = reservations.slice(startIndex, startIndex + visibleItems);
                
                reservationsChart.data.labels = visibleLabels;
                reservationsChart.data.datasets[0].data = visibleData;
                reservationsChart.update();
                
                // Activer/désactiver les boutons selon la position
                document.getElementById('scrollLeft').disabled = startIndex === 0;
                document.getElementById('scrollRight').disabled = startIndex + visibleItems >= totalItems;
            }
            
            // Gestionnaires d'événements pour les boutons
            document.getElementById('scrollLeft').addEventListener('click', function() {
                if (startIndex > 0) {
                    startIndex = Math.max(0, startIndex - Math.ceil(visibleItems / 2));
                    updateChart();
                }
            });
            
            document.getElementById('scrollRight').addEventListener('click', function() {
                if (startIndex + visibleItems < totalItems) {
                    startIndex = Math.min(totalItems - visibleItems, startIndex + Math.ceil(visibleItems / 2));
                    updateChart();
                }
            });
            
            // Mise à jour initiale pour limiter le nombre de restaurants affichés
            if (totalItems > visibleItems) {
                updateChart();
            }
            
            // Ajustement lors du redimensionnement de la fenêtre
            window.addEventListener('resize', function() {
                visibleItems = calculateVisibleItems();
                if (startIndex + visibleItems > totalItems) {
                    startIndex = Math.max(0, totalItems - visibleItems);
                }
                updateChart();
            });
        });
    </script>
    
    <!-- Styles pour les boutons de défilement -->
    <style>
        .chart-container {
            position: relative;
        }
        
        .chart-scroll-controls {
            position: absolute;
            width: 100%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            display: flex;
            justify-content: space-between;
            pointer-events: none;
            padding: 0 10px;
        }
        
        .chart-scroll-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(16, 185, 129, 0.8);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            pointer-events: auto;
            transition: background-color 0.2s;
        }
        
        .chart-scroll-btn:hover {
            background-color: rgba(16, 185, 129, 1);
        }
        
        .chart-scroll-btn:disabled {
            background-color: rgba(16, 185, 129, 0.3);
            cursor: not-allowed;
        }
        
        .chart-wrapper {
            margin: 0 40px;
        }
    </style>
@endsection