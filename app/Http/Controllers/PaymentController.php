<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Support\Facades\Auth; // Ajouté pour accéder à l'utilisateur authentifié

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        // Récupérer le panier de la session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Votre panier est vide.'); // Redirection vers le panier si vide
        }

        // Calcul du sous-total comme dans la vue
        $subtotal = 0;
        foreach ($cart as $menu) {
            $subtotal += $menu['price'] * $menu['quantity'];
        }

        // Calcul des frais de service (10% du sous-total)
        $serviceFeePercentage = 0.10;
        $serviceFee = round($subtotal * $serviceFeePercentage);

        // Le total de la commande avant la déduction des Yums
        $totalBeforeYums = $subtotal + $serviceFee;

        // Récupérer les données envoyées par le formulaire
        $requestedAmount = (float) $request->amount; // Le montant final à payer
        $yumsUsedOnPayment = (int) $request->yums_used_on_payment;

        // --- Récupérer les paramètres des Yums (doivent être cohérents avec la vue) ---
        $yumsIncrement = 100;
        $yumsValuePerIncrement = 1000;
        $minOrderAmountForYums = 2000;
        $maxAllowedYumsPerOrder = 100;

        // Récupérer l'utilisateur authentifié
        $client = Auth::guard('client')->user();

        // --- DÉBUT DES VALIDATIONS CÔTÉ SERVEUR ---

        // 1. Validation de l'utilisateur
        if (!$client) {
            return redirect()->route('cart')->with('error', 'Vous devez être connecté pour effectuer un paiement.');
        }

        // 2. Validation du montant total de la commande pour l'utilisation des Yums
        if ($yumsUsedOnPayment > 0 && $totalBeforeYums < $minOrderAmountForYums) {
            return redirect()->route('cart')->with('error', 'Le montant de votre commande est inférieur à ' . number_format($minOrderAmountForYums, 0, ',', ' ') . ' XOF. Vous ne pouvez pas utiliser de Yums.');
        }

        // 3. Validation de la quantité de Yums utilisée
        if ($yumsUsedOnPayment < 0) { // S'assurer que ce n'est pas négatif
            return redirect()->route('cart')->with('error', 'Quantité de Yums invalide.');
        }
        if ($yumsUsedOnPayment % $yumsIncrement !== 0) { // Doit être un multiple de 100
             return redirect()->route('cart')->with('error', 'Les Yums doivent être utilisés par multiples de ' . $yumsIncrement . '.');
        }
        if ($yumsUsedOnPayment > $maxAllowedYumsPerOrder) { // Ne doit pas dépasser la limite par commande
            return redirect()->route('cart')->with('error', 'Vous ne pouvez utiliser qu\'un maximum de ' . $maxAllowedYumsPerOrder . ' Yums par commande.');
        }

        // 4. Validation du solde de Yums du client
        $availableYums = $client->yums ?? 0;
        if ($yumsUsedOnPayment > $availableYums) {
            return redirect()->route('cart')->with('error', 'Vous n\'avez pas suffisamment de Yums disponibles.');
        }

        // 5. Calcul de la réduction Yums basée sur les Yums utilisés
        $yumsDiscount = ($yumsUsedOnPayment / $yumsIncrement) * $yumsValuePerIncrement;

        // 6. Calcul du montant final attendu côté serveur
        $expectedFinalAmount = $totalBeforeYums - $yumsDiscount;

        // S'assurer que le montant final n'est pas négatif
        if ($expectedFinalAmount < 0) {
            $expectedFinalAmount = 0;
            // Si le montant devient négatif, la réduction Yums est plafonnée au totalBeforeYums
            $yumsDiscount = $totalBeforeYums;
            // Les Yums réellement utilisés devraient correspondre à cette réduction plafonnée
            $yumsUsedOnPayment = floor($yumsDiscount / $yumsValuePerIncrement) * $yumsIncrement;
        }

        // 7. Comparaison du montant envoyé par le client avec le montant calculé côté serveur
        if (round($requestedAmount) !== round($expectedFinalAmount)) { // Utiliser round pour comparer les flottants
            \Log::error('Mismatch in payment amount: Requested ' . $requestedAmount . ' vs Expected ' . $expectedFinalAmount);
            return redirect()->route('cart')->with('error', 'Erreur de calcul du montant de la commande. Veuillez réessayer.');
        }

        // --- FIN DES VALIDATIONS CÔTÉ SERVEUR ---


        $config = [
            'secret_key' => config('services.fedapay.secret_key', env('FEDAPAY_SECRET_KEY')),
            'environment' => config('services.fedapay.environment', env('FEDAPAY_ENV')),
        ];
    
        FedaPay::setApiKey($config['secret_key']);
        FedaPay::setEnvironment($config['environment']);
    
        try {
            $transaction = Transaction::create([
                "description" => "Paiement de commande",
                "amount" => $expectedFinalAmount,
                "currency" => ["iso" => "XOF"],
                "customer" => [
                    "firstname" => $request->firstname,
                    "lastname" => $request->lastname,
                    "email" => $request->email,
                    "phone_number" => [
                        "number" => $request->phone,
                        "country" => "BJ" // Ou un autre code pays par défaut si nécessaire
                    ]
                ]
            ]);
    
            $token = $transaction->generateToken();

            // Stocker les Yums utilisés dans la session ou une base de données temporaire
            // pour les déduire si le paiement est un succès.
            session()->put('yums_used_for_current_transaction', $yumsUsedOnPayment);
            session()->put('current_transaction_id', $transaction->id); // Pour référence si besoin

            return redirect($token->url);

        } catch (\Exception $e) {
            \Log::error('FedaPay payment error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // --- MODIFICATION ICI : Redirection vers la page du panier en cas d'échec ---
            return redirect()->route('cart')->with('error', 'Erreur lors du paiement : ' . $e->getMessage());
        }
    }
    

    public function success(Request $request)
    {
        // Cette méthode est appelée après un paiement réussi par FedaPay.
        // C'est ici que vous devriez finaliser la commande et déduire les Yums.

        // Vérifier le statut de la transaction FedaPay pour s'assurer que c'est bien réussi
        // (Cela nécessite l'ID de transaction qui pourrait être passé via la redirection ou récupéré du callback)
        // Pour un exemple simple, on se basera sur la session.
        
        $transactionId = session()->get('current_transaction_id');
        $yumsUsed = session()->pull('yums_used_for_current_transaction', 0); // Récupérer et supprimer des Yums

        // Ici, vous devriez probablement interroger l'API FedaPay pour confirmer le statut
        // de la transaction avec $transactionId avant de déduire les Yums et vider le panier.
        // Exemple (simplifié, vérifiez la doc FedaPay pour la méthode exacte de vérification de transaction) :
        // FedaPay::setApiKey(...);
        // FedaPay::setEnvironment(...);
        // $transaction = Transaction::retrieve($transactionId);
        // if ($transaction->status === 'approved') { ... }

        $client = Auth::guard('client')->user();
        if ($client && $yumsUsed > 0) {
            $client->yums -= $yumsUsed;
            $client->save();
            session()->flash('success', 'Votre paiement a été un succès ! ' . $yumsUsed . ' Yums ont été déduits de votre solde.');
        } else {
             session()->flash('success', 'Votre paiement a été un succès !');
        }

        // Vider le panier de la session
        session()->forget('cart');
        session()->forget('current_transaction_id'); // Nettoyer la session

        return view('client.payment_success');
    }

    public function callback(Request $request)
    {
        // Point de terminaison du webhook FedaPay pour les mises à jour asynchrones des transactions.
        // C'est la méthode la plus fiable pour gérer les statuts de transaction.
        // Vous devrez configurer cette URL dans votre compte FedaPay.

        // Log the incoming callback data for debugging
        \Log::info('FedaPay Callback Received:', $request->all());

        // Assuming FedaPay sends transaction ID or other relevant info in the callback
        $transactionId = $request->input('id'); // Or 'data.id' depending on FedaPay's webhook structure
        $status = $request->input('status'); // Or 'data.status'

        if ($transactionId && $status) {
            // Retrieve transaction details from FedaPay to confirm authenticity and status
            FedaPay::setApiKey(config('services.fedapay.secret_key', env('FEDAPAY_SECRET_KEY')));
            FedaPay::setEnvironment(config('services.fedapay.environment', env('FEDAPAY_ENV')));

            try {
                $transaction = Transaction::retrieve($transactionId);

                if ($transaction->status === 'approved' && $transaction->approved_at !== null) {
                    // Transaction is confirmed as successful
                    // Retrieve yums used from your database (if stored per transaction)
                    // Or, if you use the session approach as above, you'd need a more robust way
                    // to link the callback to a specific order and its yums usage.
                    // For example, store yums used in your 'orders' table.

                    // For now, let's assume you'd have the order_id from the transaction metadata
                    // or a lookup in your DB based on transactionId.
                    // $order = Order::where('fedapay_transaction_id', $transactionId)->first();
                    // if ($order && !$order->yums_deducted) {
                    //     $client = User::find($order->user_id);
                    //     if ($client && $order->yums_used > 0) {
                    //         $client->yums -= $order->yums_used;
                    //         $client->save();
                    //     }
                    //     $order->update(['status' => 'paid', 'yums_deducted' => true]);
                    // }
                    \Log::info('FedaPay Transaction ' . $transactionId . ' approved.');

                } else {
                    \Log::warning('FedaPay Transaction ' . $transactionId . ' not approved. Current status: ' . $transaction->status);
                }
            } catch (\Exception $e) {
                \Log::error('Error retrieving FedaPay transaction in callback: ' . $e->getMessage(), ['transaction_id' => $transactionId]);
                return response()->json(['error' => 'Failed to process callback'], 500);
            }
        }

        return response()->json(['message' => 'Callback received and processed']);
    }

    public function cancel(Request $request)
    {
        // FedaPay peut renvoyer l'ID de transaction même en cas d'échec/annulation,
        // vous pouvez le logger ou l'utiliser pour un suivi si nécessaire.
        $transactionId = session()->pull('current_transaction_id'); // Récupérer et nettoyer l'ID
        \Log::info('Payment cancelled or failed by user.', ['transaction_id' => $transactionId]);

        // Retourne à la page du panier avec un message d'erreur.
        // Le panier n'est PAS vidé ici, car le paiement n'a pas été finalisé.
        return redirect()->route('cart')->with('error', 'Le paiement a été annulé ou a échoué. Veuillez réessayer.');
    }
}