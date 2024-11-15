<?php


use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('product.index');


// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware([
    'auth:sanctum',
    'roles:admin',
    'verified',
])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/productTypes', [AdminController::class, 'productType'])->name('admin.productTypes');
    Route::get('/admin/productGroups', [AdminController::class, 'productGroup'])->name('admin.productGroups');
    Route::get('/admin/productKinds', [AdminController::class, 'productKind'])->name('admin.productKinds');
});

require __DIR__ . '/auth.php';
