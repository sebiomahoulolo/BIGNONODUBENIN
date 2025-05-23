<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::get('/products', [PageController::class, 'products'])->name('pages.products');
Route::get('/categories', [PageController::class, 'categories'])->name('pages.categories');

// Routes du panier
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Routes pour les produits
Route::prefix('products')->name('pages.')->group(function () {
    Route::get('/lits', [PageController::class, 'lits'])->name('lits');
    Route::get('/matelas', [PageController::class, 'matelas'])->name('matelas');
    Route::get('/canapes', [PageController::class, 'canapes'])->name('canapes');
    Route::get('/fauteuils', [PageController::class, 'fauteuils'])->name('fauteuils');
    Route::get('/tables', [PageController::class, 'tables'])->name('tables');
    Route::get('/chaises', [PageController::class, 'chaises'])->name('chaises');
    Route::get('/armoires', [PageController::class, 'armoires'])->name('armoires');
    Route::get('/buffets', [PageController::class, 'buffets'])->name('buffets');
    Route::get('/etageres', [PageController::class, 'etageres'])->name('etageres');
    Route::get('/meubles-tv', [PageController::class, 'meublesTV'])->name('meubles-tv');
    Route::get('/commodes', [PageController::class, 'commodes'])->name('commodes');
});

// Routes pour les catégories
Route::prefix('categories')->name('pages.')->group(function () {
    Route::get('/chambres', [PageController::class, 'chambres'])->name('chambres');
    Route::get('/salons', [PageController::class, 'salons'])->name('salons');
    Route::get('/salles-a-manger', [PageController::class, 'sallesAManger'])->name('salles-a-manger');
    Route::get('/bureaux', [PageController::class, 'bureaux'])->name('bureaux');
    Route::get('/cuisines', [PageController::class, 'cuisines'])->name('cuisines');
});

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('forgot-password', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Routes pour les utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Produits
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/delete-image', [ProductController::class, 'deleteImage'])->name('products.delete-image');
    
    // Catégories
    Route::resource('categories', CategoryController::class);
    
    // Commandes
    Route::resource('orders', OrderController::class);
    
    // Clients
    Route::resource('customers', CustomerController::class);
    
    // Paramètres
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    
    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
    });
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); // J'ajoute .test pour éviter conflit avec un nom existant
Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
Route::get('/admin/blog', [BlogController::class, 'index'])->name('admin.blog.index');
Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');

Route::get('/products/{id}', [PageController::class, 'productDetail'])->name('pages.product.detail');

// ... autres routes ...