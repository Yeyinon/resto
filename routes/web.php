<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\MenuController;
use GuzzleHttp\Middleware;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusMail;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*-----------------------------Restaurant routes--------------------------------- */

Route::prefix('restaurant')->group(function () {
    // Route::get('/info', [RestaurantController::class, 'info'])->name('info');
    //Auth ROUTES
    Route::get('/login', [RestaurantController::class, 'login'])->name('login_form');
    Route::post('/connect', [RestaurantController::class, 'connect'])->name('restaurant.login');
    Route::get('/register', [RestaurantController::class, 'register'])->name('restaurant.register');
    Route::post('/create', [RestaurantController::class, 'create'])->name('restaurant.register.create');
    Route::get('/search', [RestaurantController::class, 'search'])->name('search');


    //middleware ROUTES
    Route::middleware(['Restaurant'])->group(function () {

        Route::get('/logout', [RestaurantController::class, 'logout'])->name('restaurant.logout');
        Route::get('/dashboard', [RestaurantController::class, 'dashboard'])->name('restaurant.dashboard');
        Route::get('/profile', [RestaurantController::class, 'profile'])->name('restaurant.profile');
        Route::post('/update', [RestaurantController::class, 'update'])->name('restaurant.update.profile');

        //Menu
        Route::resource('menus', MenuController::class)->names([
            'index' => 'restaurant.menus.index',
            'create' => 'restaurant.menus.create',
            'store' => 'restaurant.menus.store',
            'edit' => 'restaurant.menus.edit',
            'update' => 'restaurant.menus.update',
            'destroy' => 'restaurant.menus.destroy',
            'show' => 'restaurant.menus.show',
        ]);


        //manage Tables
        Route::get('/tables', [TableController::class, 'index'])->name('restaurant.tables');
        Route::get('/reservations', [ReservationController::class, 'reservation'])->name('restaurant.reservations');
        Route::get('/new-table', [TableController::class, 'create'])->name('restaurant.table.create');
        Route::post('/store-table', [TableController::class, 'store'])->name('restaurant.table.store');
        Route::post('/update-table', [TableController::class, 'update'])->name('table.update');
        Route::post('/destroy-table', [TableController::class, 'destroy'])->name('table.delete');


        // Approve or Reject Reservation
        Route::post('/reservation/{id}/approve', [ReservationController::class, 'approve'])->name('restaurant.reservation.approve');
        Route::post('/reservation/{id}/reject', [ReservationController::class, 'reject'])->name('restaurant.reservation.reject');

        Route::post('/reservation/{id}/status', function (Request $request, $id) {
            $request->validate([
                'status' => 'required|in:approved,rejected',
                'rejection_reason' => 'nullable|string|max:255',
            ]);

            $reservation = Reservation::with('client')->findOrFail($id);

            $reservation->status = $request->status;
            $reservation->rejection_reason = $request->status === 'rejected' ? $request->rejection_reason : null;
            $reservation->save();

            $details = [
                'clientName' => $reservation->client->name,
                'status' => $reservation->status,
                'rejection_reason' => $reservation->rejection_reason
            ];

            Mail::to($reservation->client->email)->send(new ReservationStatusMail($details));

            return response()->json(['message' => 'Statut mis à jour et email envoyé.']);
        });
    });
});

/*-----------------------------End Restaurant routes----------------------------- */

/*------------------------------Client routes----------------------------------- */
Route::prefix('client')->group(function () {

    Route::get('/book/{id}', [ClientController::class, 'book'])->name('book');

    //Auth ROUTES
    Route::get('/login', [ClientController::class, 'login'])->name('client_login_form');
    Route::post('/connect', [ClientController::class, 'connect'])->name('client.login');
    Route::get('/register', [ClientController::class, 'register'])->name('client.register');
    Route::post('/create', [ClientController::class, 'create'])->name('client.register.create');
    //middleware ROUTES
    Route::middleware(['Client'])->group(function () {

        Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::get('/logout', [ClientController::class, 'logout'])->name('client.logout');
        Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
        Route::get('/profile', [ClientController::class, 'profile'])->name('client.profile');
        Route::post('/update', [ClientController::class, 'update'])->name('client.update');
        Route::post('/reserve', [ClientController::class, 'reserve'])->name('client.reservation.create');
        Route::get('/reservations', [ClientController::class, 'reservations'])->name('client.reservations');
        Route::post('/destroy-reservation', [ReservationController::class, 'destroy'])->name('reservation.delete');
        Route::get('/menu', [MenuController::class, 'clientIndex'])->name('client.menu');
        Route::post('/reservation/{id}/cancel', [ClientController::class, 'requestCancellation'])
            ->name('reservation.cancel');


        // Afficher les menus du restaurant
        Route::get('/client/menu/{restaurant_id}', [ClientController::class, 'showMenu'])->name('client.menu');

        Route::get('/reservation/confirmation/{reservation}', [ReservationController::class, 'confirmation'])->name('client.reservation.confirmation');

        Route::get('/mon-panier', [CartController::class, 'show'])->name('client.cart.show');

        // 🛒 Routes du panier
        Route::post('/cart/add', [CartController::class, 'add'])->name('client.cart.add');
        Route::get('/cart', [CartController::class, 'view'])->name('client.cart.view');
        Route::post('/payment/fedapay', [PaymentController::class, 'pay'])->name('fedapay.pay');
        Route::get('/payment/fedapay/success', [PaymentController::class, 'success'])->name('fedapay.success');
        Route::post('/payment/fedapay/callback', [PaymentController::class, 'callback'])->name('fedapay.callback');


    });
});
/*-----------------------------End Client routes-------------------------------- */

/*------------------------------admin routes----------------------------------- */
Route::prefix('admin')->group(function () {
    //Auth ROUTES
    Route::get('/login', [AdminController::class, 'login'])->name('admin_login_form');
    Route::post('/connect', [AdminController::class, 'connect'])->name('admin.login');
    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/create', [AdminController::class, 'create'])->name('admin.register.create');
    //middleware ROUTES
    Route::middleware(['Admin'])->group(function () {

        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        //manage restaurants
        Route::get('/restaurants', [RestaurantController::class, 'restaurants'])->name('Admin.restaurants');
        Route::post('/update-restaurant', [RestaurantController::class, 'update'])->name('restaurant.update');
        Route::post('/destroy-restaurant', [RestaurantController::class, 'destroy'])->name('restaurant.delete');
        //manage clients
        Route::get('/clients', [ClientController::class, 'clients'])->name('Admin.clients');
        Route::post('/update-client', [ClientController::class, 'update'])->name('client.update');
        Route::post('/destroy-client', [ClientController::class, 'destroy'])->name('client.delete');
    });
});
/*-----------------------------End admin routes-------------------------------- */


Route::post('/test', [AdminController::class, 'test'])->name('test');


//Common routes
Route::get('/', function () {
    $restaurants = Restaurant::all();
    return view('index', compact("restaurants"));
});

Route::get('/restaurants', function () {
    $nbr_resto = Restaurant::count();
    $restaurants = Restaurant::all();
    return view('view_all', compact("restaurants", "nbr_resto"));
})->name('view_all');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/confidentialite', function () {
    return view('confidentialite');
})->name('confidentialite');

Route::post('/webhook/fedapay', [App\Http\Controllers\WebhookController::class, 'handle']);


require __DIR__ . '/auth.php';
