
@extends('master')

@section('guest')
<title>Resto - Mon Panier</title>

<!-- Page Title Section -->
<div class="page-title-section">
    <div class="container">
        <h1 class="page-title">Mon Panier</h1>
        <div class="breadcrumb-modern">
            <a href="/" class="breadcrumb-item">Accueil</a>
            <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            <span class="breadcrumb-item active">Panier</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container-custom">
        @if(count($cart) > 0)
        <div class="cart-items">
    @foreach ($cart as $menu)
        <div class="content-card cart-item">
            <div class="cart-item-header">
                <i class="fas fa-utensils"></i>
                <h3>{{ $menu['name'] }}</h3>
            </div>
            <div class="cart-item-content">
                <div class="cart-quantity">
                    <span class="quantity-label">Quantité</span>
                    <span class="quantity-value">{{ $menu['quantity'] }}</span>
                </div>
                
                <div class="plat-list">
                    <div class="plat-item">
                        <div class="plat-info">
                            <i class="fas fa-leaf"></i>
                            <span>{{ $menu['name'] }}</span>
                        </div>
                        <div class="plat-price">{{ number_format($menu['price'], 0, ',', ' ') }} XOF</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


            @php
                $serviceFee = $total * 0.1;
                $grandTotal = $total + $serviceFee;
            @endphp

            <div class="content-card payment-section">
                <div class="payment-header">
                    <h2>Récapitulatif de la commande</h2>
                </div>
                
                <div class="payment-details">
                    <div class="fee-item">
                        <span>Sous-total</span>
                        <span>{{ number_format($total, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="fee-item">
                        <span>Frais de service (10%)</span>
                        <span>{{ number_format($serviceFee, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="fee-item total">
                        <span>Total</span>
                        <span>{{ number_format($grandTotal, 0, ',', ' ') }} XOF</span>
                    </div>
                </div>
                
                <div class="payment-form">
                    <h3>Informations de paiement</h3>
                    <form action="{{ route('fedapay.pay') }}" method="POST" id="payment-form">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <input type="text" name="firstname" class="form-control-custom" placeholder="Prénom" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastname" class="form-control-custom" placeholder="Nom" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control-custom" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control-custom" placeholder="Téléphone (ex: 97000000)" required>
                            </div>
                        </div>

                        <input type="hidden" name="amount" value="{{ $grandTotal }}">

                        <button type="submit" class="btn-primary-custom payment-button">
                            <span class="spinner"></span>
                            <span class="button-text">Payer</span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="content-card empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>Votre panier est vide</h3>
                <p>Explorez nos restaurants et ajoutez des plats à votre panier.</p>
                <a href="{{ route('view_all') }}" class="btn-primary-custom">
                    <i class="fas fa-utensils"></i> Découvrir les restaurants
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    /* Styles pour la page du panier */
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 30px;
    }

    .cart-item {
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .cart-item:hover {
        transform: translateY(-5px);
    }

    .cart-item-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 15px 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .cart-item-header i {
        font-size: 1.5rem;
    }

    .cart-item-header h3 {
        margin: 0;
        font-weight: 600;
        color: white;
    }

    .cart-item-content {
        padding: 20px 25px;
    }

    .cart-quantity {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .quantity-label {
        font-weight: 500;
        color: var(--text-dark);
    }

    .quantity-value {
        background-color: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
    }

    .plat-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .plat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        background-color: var(--background-light);
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .plat-item:hover {
        background-color: var(--primary-light);
    }

    .plat-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .plat-info i {
        color: var(--primary-color);
    }

    .plat-price {
        font-weight: 600;
        color: var(--primary-color);
        padding: 5px 15px;
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    /* Payment Section */
    .payment-section {
        margin-top: 30px;
    }

    .payment-header {
        margin-bottom: 25px;
    }

    .payment-header h2 {
        color: var(--text-dark);
        font-weight: 600;
        position: relative;
        padding-bottom: 12px;
    }

    .payment-header h2:after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 3px;
    }

    .payment-details {
        background-color: var(--background-light);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .fee-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed var(--border-color);
    }

    .fee-item:last-child {
        border-bottom: none;
    }

    .fee-item.total {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-top: 10px;
    }

    .payment-form {
        margin-top: 30px;
    }

    .payment-form h3 {
        font-size: 1.2rem;
        margin-bottom: 20px;
        color: var(--text-dark);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--background-light);
        transition: all 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px var(--primary-light);
        outline: none;
    }

    .payment-button {
        position: relative;
        width: 100%;
        padding: 15px;
        font-size: 1.1rem;
        justify-content: center;
    }

    .spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 3px solid white;
        border-top: 3px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: var(--primary-light);
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        color: var(--text-dark);
        margin-bottom: 15px;
    }

    .empty-cart p {
        color: #64748b;
        margin-bottom: 30px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('payment-form');
        if (form) {
            form.addEventListener('submit', function() {
                const button = this.querySelector('.payment-button');
                const spinner = button.querySelector('.spinner');
                const buttonText = button.querySelector('.button-text');
                
                button.disabled = true;
                spinner.style.display = 'inline-block';
                buttonText.textContent = 'Traitement en cours...';
            });
        }
    });
</script>
@endsection