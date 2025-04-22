<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class CartController extends Controller
{
    // Ajouter un menu au panier
    public function add(Request $request)
    {
        $menuId = $request->input('menu_id');
        $quantity = $request->input('quantity', 1);

        $menu = Menu::with('plats')->findOrFail($menuId);

        $cart = session()->get('cart', []);

        $cart[$menuId] = [
            'id' => $menu->id,
            'nom' => $menu->nom,
            'plats' => $menu->plats,
            'quantité' => $quantity,
            'prix' => $menu->plats->sum('prix') * $quantity,
        ];

        session()->put('cart', $cart);

        // 🔁 Rediriger vers la page précédente avec message
        return redirect()->back()->with('success', 'Menu ajouté au panier avec succès !');
    }

    // Valider le panier et rediriger vers la page de paiement
    public function checkout()
    {
        // Logique pour vérifier le panier et rediriger vers une page de paiement
        return redirect()->route('payment.page'); // Exemple, à adapter selon ta plateforme de paiement
    }

    public function show()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $menu) {
            $total += $menu['prix'];
        }

        return view('client.cart', compact('cart', 'total'));
    }

    public function payWithFedaPay(Request $request)
    {
        FedaPay::setEnvironment(config('services.fedapay.environment')); // sandbox ou live
        FedaPay::setApiKey(config('services.fedapay.secret_key'));

        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $menu) {
            $subtotal += $menu['prix'];
        }

        $fee = $subtotal * 0.1;
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

}
