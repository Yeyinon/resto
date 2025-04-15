<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Plat;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $restaurant = auth()->guard('restaurant')->user();
        $menus = Menu::with('plats')
            ->where('restaurant_id', $restaurant->id)
            ->get();
        
        return view('restaurant.menus.index', compact('menus'));
    }


    public function create()
    {
        return view('restaurant.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'plats.*.nom' => 'required|string|max:255',
            'plats.*.prix' => 'required|numeric',
            'plats.*.photo' => 'nullable|image|max:2048',
        ]);
    
        // 🔐 On récupère le restaurant actuellement connecté
        $restaurant = auth()->guard('restaurant')->user();
    
        // 🔗 Création du menu en le liant au restaurant
        $menu = Menu::create([
            'nom' => $request->nom,
            'restaurant_id' => auth()->guard('restaurant')->id(), // ← AJOUT
        ]);
    
        // 🥘 Création des plats associés
        foreach ($request->plats as $plat) {
            $photoPath = null;
    
            if (isset($plat['photo'])) {
                $photoPath = $plat['photo']->store('plat_images', 'public');
            }
    
            $menu->plats()->create([
                'nom' => $plat['nom'],
                'prix' => $plat['prix'],
                'photo' => $photoPath,
            ]);
        }
    
        return redirect()->route('restaurant.menus.index')->with('success', 'Menu créé avec succès.');
    }
    
}
