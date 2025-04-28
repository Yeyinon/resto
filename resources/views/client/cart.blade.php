@extends('client.master')

@section('client')
<title>Resto - Mon Panier</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .cart-container {
        padding: 50px 0;
    }
    .cart-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        transition: transform 0.3s, box-shadow 0.3s;
        background: #ffffff;
        animation: fadeIn 0.6s ease forwards;
    }
    .cart-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }
    .cart-header {
        background: linear-gradient(135deg, #2e7d32, #66bb6a);
        color: white;
        padding: 25px;
        font-size: 1.6rem;
        font-weight: bold;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .cart-body {
        padding: 25px;
    }
    .list-group-item {
        background: #f1f8e9;
        border: none;
        margin-bottom: 8px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 500;
        transition: background 0.3s;
    }
    .list-group-item:hover {
        background: #dcedc8;
    }
    .badge-plat {
        background: linear-gradient(135deg, #388e3c, #81c784);
        color: white;
        border-radius: 30px;
        padding: 5px 15px;
        font-size: 0.9rem;
        font-weight: bold;
    }
    .total-section {
        background: linear-gradient(135deg, #1b5e20, #388e3c);
        color: white;
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        margin-top: 40px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.8s ease forwards;
    }
    .total-section h1, .total-section h2, .total-section p {
        color: white;
    }
    .pay-btn {
        background: #43a047;
        border: none;
        padding: 15px 40px;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 50px;
        color: white;
        margin-top: 20px;
        transition: background 0.3s;
        position: relative;
    }
    .pay-btn:hover {
        background: #388e3c;
    }
    .pay-btn[disabled] {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 3px solid #fff;
        border-top: 3px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
    }
    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }
    .input-group-custom input {
        border-radius: 10px;
        padding: 12px;
        background-color: #e0e0e0;
        border: none;
    }
    .input-group-custom input:focus {
        background-color: #d0d0d0;
        box-shadow: none;
    }
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(30px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>

<div class="container cart-container">
    <h1 class="text-center text-success mb-5">🛒 Mon Panier</h1>

    @if(count($cart) > 0)
        @foreach ($cart as $menu)
            <div class="cart-card">
                <div class="cart-header">
                    <i class="fas fa-utensils"></i> {{ $menu['nom'] }}
                </div>
                <div class="cart-body">
                    <p><strong>Quantité :</strong> {{ $menu['quantité'] }}</p>

                    <ul class="list-group mb-3">
                        @foreach ($menu['plats'] as $plat)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-leaf text-success me-2"></i> {{ $plat->nom }}
                                </div>
                                <span class="badge-plat">{{ number_format($plat->prix, 0, ',', ' ') }} XOF</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach

        @php
            $serviceFee = $total * 0.02;
            $grandTotal = $total + $serviceFee;
        @endphp

        <div class="total-section">
            <h2>Total à payer</h2>
            <h1>{{ number_format($grandTotal, 0, ',', ' ') }} XOF</h1>

            <form action="{{ route('fedapay.pay') }}" method="POST" id="payment-form" class="mt-4">
                @csrf
                <div class="row input-group-custom">
                    <div class="col-md-3 mb-3">
                        <input type="text" name="firstname" class="form-control" placeholder="Prénom" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="lastname" class="form-control" placeholder="Nom" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="Téléphone (ex: 97000000)" required>
                    </div>
                </div>

                <input type="hidden" name="amount" value="{{ $grandTotal }}">

                <button type="submit" class="pay-btn">
                    <div class="spinner" id="spinner"></div>
                    <span id="btn-text">Payer avec FedaPay</span>
                </button>
            </form>
        </div>
    @else
        <div class="alert alert-info text-center">
            Votre panier est vide.
        </div>
    @endif
</div>

<!-- Script pour activer le Loading -->
<script>
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        var btn = e.target.querySelector('.pay-btn');
        var spinner = btn.querySelector('#spinner');
        var btnText = btn.querySelector('#btn-text');

        btn.disabled = true;
        spinner.style.display = 'inline-block';
        btnText.textContent = 'Traitement...';
    });
</script>
@endsection
