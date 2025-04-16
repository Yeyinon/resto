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

    public function edit(Menu $menu)
    {
        // Vérifie que le menu appartient bien au restaurant connecté
        $restaurant = auth()->guard('restaurant')->user();
        if ($menu->restaurant_id !== $restaurant->id) {
            abort(403);
        }

        // Charge les plats du menu
        $menu->load('plats');

        return view('restaurant.menus.edit', compact('menu'));
    }


    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'plats.*.nom' => 'nullable|string|max:255',
            'plats.*.prix' => 'nullable|numeric',
            'plats.*.photo' => 'nullable|image|max:2048',
            'new_plats.*.nom' => 'nullable|string|max:255',
            'new_plats.*.prix' => 'nullable|numeric',
            'new_plats.*.photo' => 'nullable|image|max:2048',
        ]);
    
        // ✅ Mise à jour du nom du menu
        $menu->update([
            'nom' => $request->nom,
        ]);
    
        // ✅ Mise à jour des plats existants
        if ($request->has('plats')) {
            foreach ($request->plats as $platData) {
                if (isset($platData['id'])) {
                    $plat = Plat::find($platData['id']);
                    if ($plat && $plat->menu_id == $menu->id) {
                        $data = [
                            'nom' => $platData['nom'],
                            'prix' => $platData['prix'],
                        ];
    
                        // 📷 Mise à jour de la photo si une nouvelle a été envoyée
                        if (isset($platData['photo']) && $platData['photo']) {
                            $data['photo'] = $platData['photo']->store('plat_images', 'public');
                        }
    
                        $plat->update($data);
                    }
                }
            }
        }
    
        // ➕ Ajout de nouveaux plats
        if ($request->has('new_plats')) {
            foreach ($request->new_plats as $newPlat) {
                if (!empty($newPlat['nom']) && !empty($newPlat['prix'])) {
                    $photoPath = null;
    
                    if (isset($newPlat['photo']) && $newPlat['photo']) {
                        $photoPath = $newPlat['photo']->store('plat_images', 'public');
                    }
    
                    $menu->plats()->create([
                        'nom' => $newPlat['nom'],
                        'prix' => $newPlat['prix'],
                        'photo' => $photoPath,
                    ]);
                }
            }
        }
    
        return redirect()->route('restaurant.menus.index')->with('success', 'Menu mis à jour avec succès.');
    }
    

    public function destroy(Menu $menu)
    {
        // 🔒 Vérification que le menu appartient bien au restaurant connecté
        $restaurant = auth()->guard('restaurant')->user();
        if ($menu->restaurant_id !== $restaurant->id) {
            abort(403);
        }

        // 🗑️ Suppression des plats associés
        foreach ($menu->plats as $plat) {
            if ($plat->photo) {
                \Storage::disk('public')->delete($plat->photo);
            }
            $plat->delete();
        }

        // 🔥 Suppression du menu
        $menu->delete();

        return redirect()->route('restaurant.menus.index')->with('success', 'Menu supprimé avec succès.');
    }

}
