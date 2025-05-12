@extends('restaurant.master')
@section('restaurant')
<style>
    /* Reset et styles de base */
    body, html {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background-color: #f0fbf5;
        color: #2d3748;
        overflow: hidden; /* Empêcher le double scrolling */
    }

    .dashboard-container {
        display: flex;
        height: 100vh;
        width: 100%;
        overflow: hidden; /* Empêcher les barres de défilement horizontales */
    }

    .main-content {
        flex-grow: 1;
        padding: 1rem;
        overflow-y: auto; /* Une seule barre de défilement verticale */
        overflow-x: hidden; /* Pas de défilement horizontal */
        height: 100vh;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background-color: #ffffff;
        border-radius: 15px;
        padding: 1.25rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
        display: flex;
        flex-direction: column;
    }

    .stat-icon {
        color: #10b981;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .stat-trend {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .trend-positive {
        color: #10b981;
    }

    .trend-negative {
        color: #ef4444;
    }

    /* Chart Section */
    .chart-section {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        /* Hauteur fixe pour éviter le redimensionnement incorrect */
        height: 450px;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .chart-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.125rem;
        font-weight: 600;
        color: #334155;
    }

    .chart-filters {
        display: flex;
        gap: 0.5rem;
    }

    .chart-filter-btn {
        background-color: #f0f0f0;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .chart-filter-btn:hover {
        background-color: #e5ffe5;
    }

    .chart-filter-btn.active {
        background-color: #10b981;
        color: white;
        border-color: #10b981;
    }

    /* Chart Container */
    .chart-container {
        width: 100%;
        height: 330px; /* Hauteur fixe pour le graphique */
        position: relative;
    }

    /* Pour corriger les classes Tailwind non disponibles */
    .text-emerald-500 {
        color: #10b981;
    }
</style>

<div class="dashboard-container">
    <main class="main-content">
        <!-- Statistics Grid -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-value">{{ $reservationCount }}</div>
                <div class="stat-trend">
                    Réservations Totales
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-value">{{ $uniqueClients }}</div>
                <div class="stat-trend">
                    Clients Uniques
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-percent"></i></div>
                <div class="stat-value">{{ number_format($reservationRate, 1) }}%</div>
                <div class="stat-trend {{ $reservationRate >= 50 ? 'trend-positive' : 'trend-negative' }}">
                    {{ $reservationRate >= 50 ? '▲' : '▼' }} Taux de Réservation
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-euro-sign"></i></div>
                <div class="stat-value">{{ number_format($totalRevenue, 2) }} XOF</div>
                <div class="stat-trend {{ $revenueGrowth >= 0 ? 'trend-positive' : 'trend-negative' }}">
                    {{ $revenueGrowth >= 0 ? '▲' : '▼' }} {{ abs($revenueGrowth) }}% ce mois
                </div>
            </div>
        </section>

        <!-- Graphique des Réservations -->
        <div class="chart-section">
            <div class="chart-header">
                <div class="chart-title">
                    <i class="fas fa-chart-line text-emerald-500"></i>
                    Réservations par Période
                </div>
                <div class="chart-filters">
                    <button class="chart-filter-btn active" data-period="week">Semaine</button>
                    <button class="chart-filter-btn" data-period="month">Mois</button>
                    <button class="chart-filter-btn" data-period="year">Année</button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="reservationChart"></canvas>
            </div>
        </div>
    </main>
</div>

<script>
    // Attendre que le DOM soit complètement chargé
    document.addEventListener('DOMContentLoaded', function() {
        // S'assurer que Chart.js est chargé avant de l'utiliser
        if (typeof Chart === 'undefined') {
            // Si Chart.js n'est pas chargé, on le charge dynamiquement
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js';
            script.onload = initializeChart;
            document.head.appendChild(script);
        } else {
            // Si Chart.js est déjà chargé, initialiser le graphique
            initializeChart();
        }
    });

    function initializeChart() {
        // Détruire le graphique existant s'il y en a un
        if (window.reservationChart instanceof Chart) {
            window.reservationChart.destroy();
        }

        // Récupérer le canvas
        const ctx = document.getElementById('reservationChart').getContext('2d');
        
        // Définir les données initiales du graphique
        const initialChartData = {
            labels: {!! $chartLabels !!},
            datasets: [{
                label: 'Réservations',
                data: {!! $chartData !!},
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: '#10b981',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true
            }]
        };

        // Configuration du graphique
        const chartConfig = {
            type: 'line',
            data: initialChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                family: "'Segoe UI', Arial, sans-serif"
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: "'Segoe UI', Arial, sans-serif"
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                family: "'Segoe UI', Arial, sans-serif"
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            family: "'Segoe UI', Arial, sans-serif"
                        },
                        bodyFont: {
                            family: "'Segoe UI', Arial, sans-serif"
                        },
                        padding: 10,
                        cornerRadius: 6,
                        displayColors: false
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animation: {
                    duration: 1000
                },
                elements: {
                    line: {
                        borderJoinStyle: 'round'
                    }
                }
            }
        };

        // Créer l'instance du graphique
        window.reservationChart = new Chart(ctx, chartConfig);
        
        // Gérer les filtres de période
        setupPeriodFilters();
    }

    function setupPeriodFilters() {
        const filterButtons = document.querySelectorAll('.chart-filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Retirer la classe active de tous les boutons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Ajouter la classe active au bouton cliqué
                this.classList.add('active');
                
                // Récupérer la période sélectionnée
                const period = this.dataset.period;
                
                // Charger les données pour cette période
                fetchChartData(period);
            });
        });
    }

    function fetchChartData(period) {
        // Afficher un état de chargement si nécessaire
        if (window.reservationChart) {
            window.reservationChart.data.datasets[0].data = [];
            window.reservationChart.update();
        }

        // Récupérer les données via AJAX
        fetch(`/restaurant/chart-data?period=${period}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
                }
                return response.json();
            })
            .then(data => {
                // Mettre à jour les données du graphique
                if (window.reservationChart) {
                    window.reservationChart.data.labels = data.labels;
                    window.reservationChart.data.datasets[0].data = data.data;
                    window.reservationChart.update();
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données:', error);
                // Afficher un message d'erreur à l'utilisateur si nécessaire
            });
    }

    // S'assurer que le graphique se redimensionne correctement
    window.addEventListener('resize', function() {
        if (window.reservationChart) {
            window.reservationChart.resize();
        }
    });
</script>
@endsection