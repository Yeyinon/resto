<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Http\Kernel;
use App\Models\Menu;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // Déboguer les données reçues
        \Log::info('Requête de création de menu:', [
            'data' => $request->all()
        ]);

        // Tester la connexion du restaurant
        $restaurant = auth()->guard('restaurant')->user();
        \Log::info('Restaurant connecté:', [
            'auth_check' => auth()->guard('restaurant')->check(),
            'restaurant_id' => $restaurant ? $restaurant->id : null,
        ]);
        // Valider les données
        $request->validate([
            'nom' => 'required|string|max:255',
            'plats' => 'required|array|min:1',
            'plats.*.nom' => 'required|string',
            'plats.*.prix' => 'required|numeric',
            'plats.*.photo' => 'nullable|image|max:2048',
        ]);

        // Récupérer l'ID du restaurant connecté
        $restaurant = auth()->guard('restaurant')->user();

        // Créer le menu avec le restaurant_id
        $menu = Menu::create([
            'nom' => $request->nom,
            'restaurant_id' => $restaurant->id, // Ajouter cette ligne pour associer le menu au restaurant
        ]);

        // Ajouter les plats associés
        foreach ($request->plats as $index => $platData) {
            // Gérer la photo (si elle existe)
            $photoPath = null;
            if (isset($platData['photo']) && $platData['photo']) {
                $photoPath = $platData['photo']->store('plats', 'public');
            }

            // Créer un plat associé au menu
            $menu->plats()->create([
                'nom' => $platData['nom'],
                'prix' => $platData['prix'],
                'photo' => $photoPath,
            ]);
        }

        return redirect()->route('restaurant.menus.index')->with('success', 'Menu enregistré avec succès.');
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

    // MenuController.php
    public function clientIndex()
    {
        $menus = Menu::all();
        return view('client.menu', compact('menus'));
    }

}
