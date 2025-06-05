<?php
use Illuminate\Support\Facades\Auth;
?>

@extends('master')

@section('guest')
<title>Resto - Mon Panier</title>

<div class="page-title-section">
    <div class="container">
    </div>
</div>

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
                $subtotal = 0;
                foreach ($cart as $menu) {
                    $subtotal += $menu['price'] * $menu['quantity'];
                }
                
                // --- Calcul des frais de service (10% du sous-total) ---
                $serviceFeePercentage = 0.10;
                $serviceFee = round($subtotal * $serviceFeePercentage);

                // Le total de la commande avant la déduction des Yums
                // C'est le sous-total + les frais de service
                $totalBeforeYums = $subtotal + $serviceFee;

                // --- LOGIQUE POUR LES YUMS ---
                $client = Auth::guard('client')->user();
                $availableYums = $client->yums ?? 0;
                $yumsIncrement = 100;
                $yumsValuePerIncrement = 1000;
                
                // NOUVELLE CONTRAINTE: Montant minimum de la commande pour utiliser les Yums
                $minOrderAmountForYums = 2000; // XOF
                $canUseYums = $totalBeforeYums >= $minOrderAmountForYums;

                // NOUVELLE CONTRAINTE: L'utilisateur ne peut utiliser que 100 Yums max par commande
                $maxAllowedYumsPerOrder = 100;

                // Calcul du montant maximal de Yums que le client peut utiliser basé sur son solde
                // Et la limite par commande, et si la commande atteint le minimum requis
                $maxYumsUsableFromBalance = floor($availableYums / $yumsIncrement) * $yumsIncrement; // Toujours un multiple de 100
                
                // Assurer que le client ne peut pas demander plus de 100 Yums
                if ($maxYumsUsableFromBalance > $maxAllowedYumsPerOrder) {
                    $maxYumsUsableFromBalance = $maxAllowedYumsPerOrder;
                }

                // Calcul du montant maximal de Yums qui ne dépasse pas le total à payer (avec frais de service)
                $maxDiscountAmountPossible = $totalBeforeYums; 
                $maxYumsUsableFromOrderValue = floor($maxDiscountAmountPossible / $yumsValuePerIncrement) * $yumsIncrement;
                
                // La quantité maximale de Yums utilisable est le minimum de toutes les contraintes
                $maxYumsToUse = min($maxYumsUsableFromBalance, $maxYumsUsableFromOrderValue);

                // Si la commande n'atteint pas le montant minimum, on ne peut pas utiliser de Yums
                if (!$canUseYums) {
                    $maxYumsToUse = 0;
                }

                // Le total initial affiché sans réduction Yums
                $total = $totalBeforeYums; 
            @endphp
            
            <div class="content-card payment-section">
                <div class="payment-header">
                    <h2>Récapitulatif de la commande</h2>
                </div>
                
                <div class="payment-details">
                    <div class="fee-item">
                        <span>Sous-total</span>
                        <span>{{ number_format($subtotal, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="fee-item" style="color: #e02828; font-weight: 600;">
                        <span>Frais de service ({{ number_format($serviceFeePercentage * 100) }}%)</span>
                        <span>+ {{ number_format($serviceFee, 0, ',', ' ') }} XOF</span>
                    </div>

                    {{-- SECTION POUR L'UTILISATION DES YUMS --}}
                    @if ($availableYums > 0 && $canUseYums)
                        <div class="fee-item yums-section">
                            <span>Utiliser mes Yums (Solde: {{ $availableYums }} Yums)</span>
                            <div class="yums-control">
                                <select name="yums_to_use" id="yums_to_use" class="form-control" onchange="updateCartTotal()">
                                    <option value="0">0 Yums (Aucune réduction)</option>
                                    @for ($i = $yumsIncrement; $i <= $maxYumsToUse; $i += $yumsIncrement)
                                        <option value="{{ $i }}">{{ $i }} Yums (- {{ number_format(($i / $yumsIncrement) * $yumsValuePerIncrement, 0, ',', ' ') }} XOF)</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="fee-item discount-display">
                            <span>Réduction Yums</span>
                            <span id="yums_discount_display" class="text-success">- 0 XOF</span>
                        </div>
                    @else
                        <div class="fee-item">
                            <span>Yums disponibles</span>
                            <span class="text-muted">{{ $availableYums }} Yums</span>
                        </div>
                        <div class="alert alert-info text-center mt-3 p-2 small">
                            <i class="fas fa-info-circle me-1"></i> 
                            @if ($availableYums == 0)
                                Vous n'avez pas de Yums disponibles pour le moment.
                            @elseif (!$canUseYums)
                                Le montant de votre commande ({{ number_format($totalBeforeYums, 0, ',', ' ') }} XOF) est inférieur à {{ number_format($minOrderAmountForYums, 0, ',', ' ') }} XOF.
                                Pour utiliser les Yums, votre commande doit être d'au moins {{ number_format($minOrderAmountForYums, 0, ',', ' ') }} XOF.
                            @else
                                Pour utiliser les Yums, votre commande doit être d'au moins {{ number_format($minOrderAmountForYums, 0, ',', ' ') }} XOF et vous pouvez utiliser un maximum de {{ $maxAllowedYumsPerOrder }} Yums.
                            @endif
                        </div>
                    @endif

                    <div class="fee-item total">
                        <span>Total à payer</span>
                        <span id="final_total_display">{{ number_format($total, 0, ',', ' ') }} XOF</span>
                    </div>
                </div>
                
                <div class="payment-form">
                    <h3>Informations de paiement</h3>
                    {{-- Affichage des messages de session (success/error) --}}
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="payment-form" action="{{ route('process.payment') }}" method="POST">
                        @csrf
                        {{-- Ces champs cachés seront mis à jour par le JavaScript --}}
                        <input type="hidden" name="amount" id="payment_amount_hidden" value="{{ $total }}">
                        <input type="hidden" name="yums_used_on_payment" id="yums_used_on_payment_hidden" value="0">

                        <div class="form-grid">
                            <div class="form-group">
                                <input type="text" id="firstname" class="form-control-custom" name="firstname" value="{{ Auth::guard('client')->user()->name }}" placeholder="Prénom" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="lastname" class="form-control-custom" name="lastname" value="{{ Auth::guard('client')->user()->lastname ?? '' }}" placeholder="Nom" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <input type="email" id="email" class="form-control-custom" name="email" value="{{ Auth::guard('client')->user()->email }}" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="phone" class="form-control-custom" name="phone" value="{{ Auth::guard('client')->user()->phone ?? '' }}" placeholder="Téléphone (ex: 97000000)" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-primary-custom payment-button">
                            <span class="spinner"></span>
                            <span class="button-text">Payer maintenant</span>
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

    /* Styles pour la section Yums existante */
    .yums-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        /* border-top: 1px dashed #e2e8f0; -- Retiré car fee-item gère déjà le border-bottom */
        margin-top: 5px; /* Ajustement de la marge */
        font-weight: 500;
        color: var(--text-dark);
    }
    .yums-section select {
        max-width: 200px;
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background-color: var(--background-light);
        font-size: 0.95rem;
    }
    .discount-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 15px;
        /* border-bottom: 1px dashed #e2e8f0; -- Retiré car fee-item gère déjà le border-bottom */
        margin-bottom: 15px;
        font-weight: 500;
    }
    .discount-display span:first-child {
        color: var(--text-dark);
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
        // Initialiser le total au chargement de la page
        updateCartTotal();

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

    function updateCartTotal() {
        const subtotal = {{ $subtotal }};
        
        // --- Calcul des frais de service en JS ---
        const serviceFeePercentage = 0.10;
        const serviceFee = Math.round(subtotal * serviceFeePercentage);

        // Le total de la commande avant la déduction des Yums
        const totalBeforeYums = subtotal + serviceFee; 

        // --- Paramètres des Yums et nouvelles contraintes ---
        const yumsIncrement = {{ $yumsIncrement }};
        const yumsValuePerIncrement = {{ $yumsValuePerIncrement }};
        const minOrderAmountForYums = {{ $minOrderAmountForYums }};
        const maxAllowedYumsPerOrder = {{ $maxAllowedYumsPerOrder }};
        const availableYums = {{ $availableYums }};

        const yumsToUseSelect = document.getElementById('yums_to_use');

        let selectedYums = 0;
        if (yumsToUseSelect) {
            selectedYums = parseInt(yumsToUseSelect.value);
        }

        let yumsDiscount = (selectedYums / yumsIncrement) * yumsValuePerIncrement;
        
        // Appliquer les contraintes sur les Yums
        let actualMaxYumsToUse = 0;
        if (totalBeforeYums >= minOrderAmountForYums && availableYums > 0) {
            // Maximum de Yums utilisables selon le solde
            let maxYumsFromBalance = Math.floor(availableYums / yumsIncrement) * yumsIncrement;
            // Ne pas dépasser la limite de 100 Yums par commande
            if (maxYumsFromBalance > maxAllowedYumsPerOrder) {
                maxYumsFromBalance = maxAllowedYumsPerOrder;
            }
            // Maximum de Yums utilisables selon le montant de la commande
            let maxYumsFromOrderValue = Math.floor(totalBeforeYums / yumsValuePerIncrement) * yumsIncrement;

            actualMaxYumsToUse = Math.min(maxYumsFromBalance, maxYumsFromOrderValue);
        }

        // Si les Yums sélectionnés dépassent la limite réelle, réinitialiser
        if (selectedYums > actualMaxYumsToUse) {
            selectedYums = actualMaxYumsToUse; // Ou 0 si on veut forcer la remise à zéro si invalidé
            if (yumsToUseSelect) {
                yumsToUseSelect.value = selectedYums; // Mettre à jour la sélection visuelle
            }
            yumsDiscount = (selectedYums / yumsIncrement) * yumsValuePerIncrement;
        }


        let finalTotal = totalBeforeYums - yumsDiscount;

        // S'assurer que le total ne devienne pas négatif
        if (finalTotal < 0) {
            finalTotal = 0;
            // Ajuster la réduction Yums si elle dépasse le total initial avec frais
            yumsDiscount = totalBeforeYums;
            // Ajuster les Yums réellement utilisés pour correspondre à cette réduction
            selectedYums = Math.floor(yumsDiscount / yumsValuePerIncrement) * yumsIncrement;
            if (yumsToUseSelect) {
                yumsToUseSelect.value = selectedYums; // Mettre à jour la sélection visuelle
            }
        }

        // Mettre à jour l'affichage de la réduction Yums
        const yumsDiscountDisplay = document.getElementById('yums_discount_display');
        if (yumsDiscountDisplay) {
            yumsDiscountDisplay.textContent = '- ' + formatPrice(yumsDiscount) + ' XOF';
        }
        
        // Mettre à jour l'affichage du total final
        document.getElementById('final_total_display').textContent = formatPrice(finalTotal) + ' XOF';
        
        // Mettre à jour les champs cachés pour le contrôleur
        document.getElementById('payment_amount_hidden').value = finalTotal;
        document.getElementById('yums_used_on_payment_hidden').value = selectedYums;
    }

    function formatPrice(price) {
        return price.toLocaleString('fr-FR', { style: 'decimal', minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }
</script>
@endsection