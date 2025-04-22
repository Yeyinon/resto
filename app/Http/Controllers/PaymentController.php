<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FedaPay\FedaPay;
use FedaPay\Transaction;


class PaymentController extends Controller
{
    public function pay(Request $request)
{
    // Configuration des clés FedaPay
    FedaPay::setApiKey(env('FEDAPAY_SECRET_KEY'));
    FedaPay::setEnvironment(env('FEDAPAY_ENV')); // 'sandbox' ou 'live'

    try {
        // Création de la transaction
        $transaction = Transaction::create([
            "description" => "Paiement de commande",
            "amount" => $request->amount,
            "currency" => ["iso" => "XOF"],
            "customer" => [
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "email" => $request->email,
                "phone_number" => [
                    "number" => $request->phone,
                    "country" => "BJ" // ou "TG", selon le pays de ton projet
                ]
            ]
        ]);

        // Redirection vers FedaPay Checkout
        $token = $transaction->generateToken();
        return redirect($token->url);
    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors du paiement : ' . $e->getMessage());
    }
}

    public function success()
    {
        session()->forget('cart');
        return view('client.payment_success');
    }

    public function callback(Request $request)
    {
        // Ici tu peux enregistrer ou vérifier la transaction via l’API FedaPay
        return response()->json(['message' => 'Callback reçu']);
    }

    
}
