<?php


use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/producttype/{id}', [ProductController::class,'productCategory'])->name('product.category');
Route::get('/product/{product_id}/{producttype_id}', [ProductController::class,'productDetail'])->name('product.detail');

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
    Route::post('/admin/productBrands/create', [AdminController::class, 'productBrandCreate'])->name('admin.productBrands.create');


    Route::get('/admin/productTypes', [AdminController::class, 'productType'])->name('admin.productTypes');
    Route::post('/admin/productTypes/create', [AdminController::class, 'productTypeCreate'])->name('admin.productTypes.create');


    Route::get('/admin/productGroups', [AdminController::class, 'productGroup'])->name('admin.productGroups');
    Route::get('/admin/productGroups/create', [AdminController::class, 'productGroupCreate'])->name('admin.productGroups.create');

    Route::get('/admin/productKinds', [AdminController::class, 'productKind'])->name('admin.productKinds');
    Route::post('/admin/productKinds/create', [AdminController::class, 'productKind'])->name('admin.productKinds.create');

    Route::post('/admin/products/{id}/addPics', [AdminController::class, 'addPictures'])->name('admin.addProductPics');
    Route::delete('/admin/products/delete/{id}', [AdminController::class, 'deleteProductPictures'])->name('admin.deleteProductPics');
    Route::post('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.productCreate');
    Route::put('/admin/products/{id}/status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::post('/admin/products/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');

    Route::get('/admin/banner', [AdminController::class,'Banner'])->name('admin.banner');
    Route::put('/admin/banner/{id}/status', [AdminController::class, 'toggleBannerStatus'])->name('admin.toggleBannerStatus');
    Route::post('/admin/banner/create', [AdminController::class,'bannerAdd'])->name('admin.banner.create');
    Route::delete('/admin/banner/{id}/delete', [AdminController::class,'bannerAdd'])->name('admin.banner.delete');

    Route::get('/admin/news', [AdminController::class,'News'])->name('admin.news');
    Route::post('/admin/news/create', [AdminController::class,'NewsCrate'])->name('admin.news.create');
    Route::put('/admin/news/{id}/update', [AdminController::class,'NewsUpdate'])->name('admin.news.update');
    Route::delete('/admin/news/{id}/delete', [AdminController::class,'NewsDelete'])->name('admin.news.delete');
});
Route::middleware([
    'auth:sanctum',
    'roles:superadmin',
    'verified',
])->group(function () {
    Route::get('/admin/user', [AdminController::class, 'userAdmin'])->name('admin.userAdmin');
    Route::get('/admin/user/create', [AdminController::class, 'userAdd'])->name('admin.userAdmin.create');
});


require __DIR__ . '/auth.php';
