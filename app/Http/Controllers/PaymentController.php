<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FedaPay\FedaPay;
use FedaPay\Transaction;


class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $config = [
            'secret_key' => config('services.fedapay.secret_key', env('FEDAPAY_SECRET_KEY')),
            'environment' => config('services.fedapay.environment', env('FEDAPAY_ENV')),
        ];
    
        FedaPay::setApiKey($config['secret_key']);
        FedaPay::setEnvironment($config['environment']);
    
        try {
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
                        "country" => "BJ"
                    ]
                ]
            ]);
    
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
