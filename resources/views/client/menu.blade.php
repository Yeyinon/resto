@extends('master')

@section('guest')
    <!-- Page Title Section -->
    <div class="page-title-section">
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-custom">
            @foreach ($menus as $menu)
                <div class="content-card mb-5">
                    <h2 class="menu-category">{{ $menu->nom }}</h2>
                    <div class="menu-grid">
                        @forelse ($menu->plats as $plat)
                            <div class="dish-card">
                                <div class="dish-image">
                                    <img src="{{ asset('storage/' . $plat->photo) }}" alt="{{ $plat->nom }}">
                                </div>
                                <div class="dish-content">
                                    <h3>{{ $plat->nom }}</h3>
                                    <p class="dish-description">{{ $plat->description }}</p>
                                    <div class="dish-price">XOF {{ $plat->prix }}</div>
                                    <form action="{{ route('client.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="plat_id" value="{{ $plat->id }}">
                                                <div class="dish-actions">
                                            <div class="quantity-control">
                                                <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                                            </div>
                                            <button type="submit" class="btn-add-cart">
                                                <i class="fas fa-plus"></i> Ajouter
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="empty-menu">
                                <i class="fas fa-utensils empty-icon"></i>
                                <p>Aucun plat disponible pour ce menu.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach

            <div class="cart-action">
                <a href="{{ route('client.cart.show') }}" class="btn-primary-custom">
                    <i class="fas fa-shopping-cart"></i> Voir mon panier
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Menu Page Styles */
        .menu-category {
            color: var(--primary-dark);
            font-weight: 700;
            position: relative;
            margin-bottom: 2rem;
            padding-bottom: 0.8rem;
        }

        .menu-category:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            border-radius: 2px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 2rem;
        }

        .dish-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px var(--shadow-color);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .dish-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.2);
        }

        .dish-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .dish-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .dish-card:hover .dish-image img {
            transform: scale(1.05);
        }

        .dish-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .dish-content h3 {
            color: var(--text-dark);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .dish-description {
            color: #4b5563;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .dish-price {
            color: var(--primary-color);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .dish-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            flex-grow: 1;
            justify-content: center;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px var(--shadow-color);
        }

        .empty-menu {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.6;
        }

        .cart-action {
            text-align: center;
            margin: 40px 0;
        }

        .cart-action .btn-primary-custom {
            padding: 15px 30px;
            font-size: 1.1rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection