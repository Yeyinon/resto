<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class CartController extends Controller
{
    // Ajouter un plat au panier
    public function add(Request $request)
    {
        $platId = $request->input('plat_id');
        $quantity = $request->input('quantity', 1);

        $plat = Plat::findOrFail($platId);

        $cart = session()->get('cart', []);

        $found = false;

        foreach ($cart as &$item) {
            if ($item['id'] == $plat->id) {
                $item['quantity'] += $quantity;
                $item['total'] = $item['quantity'] * $item['price'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'id' => $plat->id,
                'name' => $plat->nom,
                'price' => $plat->prix,
                'photo' => $plat->photo,
                'quantity' => $quantity,
                'total' => $plat->prix * $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Plat ajouté au panier avec succès !');
    }

    public function show()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['total'];
        }

        return view('client.cart', compact('cart', 'total'));
    }

    public function checkout()
    {
        return redirect()->route('payment.page');
    }

    public function payWithFedaPay(Request $request)
    {
        FedaPay::setEnvironment(config('services.fedapay.environment'));
        FedaPay::setApiKey(config('services.fedapay.secret_key'));

        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['total'];
        }

        $fee = $subtotal * 0.02;
        $total = $subtotal + $fee;

        $customerData = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone_number' => [
                'number' => $request->phone,
                'country' => 'BJ',
            ],
        ];

        try {
            $transaction = Transaction::create([
                'description' => 'Paiement commande resto',
                'amount' => $total,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('fedapay.callback'),
                'customer' => $customerData,
            ]);

            return redirect($transaction->generatePaymentUrl());
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur FedaPay : ' . $e->getMessage());
        }
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, fn($item) => $item['id'] != $id);
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Plat retiré du panier.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Panier vidé.');
    }
}
