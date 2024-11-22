<?php


use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/producttype/{id}', [ProductController::class,'productCategory'])->name('product.category');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware([
    'auth:sanctum',
    'roles:admin|superadmin',
    'verified',
])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/productBrands', [AdminController::class, 'productBrand'])->name('admin.productBrands');
    Route::get('/admin/productTypes', [AdminController::class, 'productType'])->name('admin.productTypes');
    Route::get('/admin/productGroups', [AdminController::class, 'productGroup'])->name('admin.productGroups');
    Route::get('/admin/productKinds', [AdminController::class, 'productKind'])->name('admin.productKinds');
    Route::post('/admin/products/{id}/addPics', [AdminController::class, 'addPictures'])->name('admin.addProductPics');
    Route::delete('/admin/products/delete/{id}', [AdminController::class, 'deleteProductPictures'])->name('admin.deleteProductPics');
    Route::post('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.productCreate');
    Route::put('/admin/products/{id}/status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::post('/admin/products/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');

    Route::get('/admin/banner', [AdminController::class,'Banner'])->name('admin.banner');
    Route::put('/admin/banner/{id}/status', [AdminController::class, 'toggleBannerStatus'])->name('admin.toggleBannerStatus');
    Route::post('/admin/banner/create', [AdminController::class,'bannerAdd'])->name('admin.banner.create');


    Route::get('/admin/news', [AdminController::class,'News'])->name('admin.news');
});

require __DIR__ . '/auth.php';
