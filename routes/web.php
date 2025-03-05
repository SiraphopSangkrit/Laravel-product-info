<?php


use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/producttype/{id}', [ProductController::class,'productCategory'])->name('product.category');
Route::get('/product/{product_id}/{producttype_id}', [ProductController::class,'productDetail'])->name('product.detail');
Route::get('/product/search', [ProductController::class,'productSearch'])->name('product.search');
Route::get('/news', [ProductController::class,'newsList'])->name('news.index');
Route::get('/news/{id}', [ProductController::class,'newsDetail'])->name('news.detail');


Route::middleware([
    'auth:sanctum',
    'roles:admin|superadmin',
    'verified',
])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/{id}/images', [AdminController::class, 'getProductImages'])->name('admin.getProductImages');
    Route::post('/admin/products/{id}/addPics', [AdminController::class, 'addProductPictures'])->name('admin.addProductPics');
    Route::delete('/admin/products/delete/image/{id}', [AdminController::class, 'deleteProductPictures'])->name('admin.deleteProductPics');
    Route::post('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.productCreate');
    Route::put('/admin/products/{id}/status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::put('/admin/products/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');
    Route::delete('/admin/products/{id}/delete', [AdminController::class, 'deleteProduct'])->name('admin.deleteProduct');

    Route::get('/admin/productBrands', [AdminController::class, 'productBrand'])->name('admin.productBrands');
    Route::post('/admin/productBrands/create', [AdminController::class, 'productBrandCreate'])->name('admin.productBrands.create');
    Route::put('/admin/productBrands/{id}/update', [AdminController::class, 'productBrandUpdate'])->name('admin.productBrands.update');
    Route::delete('/admin/productBrands/{id}/delete', [AdminController::class, 'productBrandDelete'])->name('admin.productBrands.delete');

    Route::get('/admin/productTypes', [AdminController::class, 'productType'])->name('admin.productTypes');
    Route::post('/admin/productTypes/create', [AdminController::class, 'productTypeCreate'])->name('admin.productTypes.create');
    Route::put('/admin/productTypes/{id}/update', [AdminController::class, 'productTypeUpdate'])->name('admin.productTypes.update');
    Route::delete('/admin/productTypes/{id}/delete', [AdminController::class, 'productTypeDelete'])->name('admin.productTypes.delete');

    Route::get('/admin/productGroups', [AdminController::class, 'productGroup'])->name('admin.productGroups');
    Route::post('/admin/productGroups/create', [AdminController::class, 'productGroupCreate'])->name('admin.productGroups.create');
    Route::put('/admin/productGroups/{id}/update', [AdminController::class, 'productGroupUpdate'])->name('admin.productGroups.update');
    Route::delete('/admin/productGroups/{id}/delete', [AdminController::class, 'productGroupDelete'])->name('admin.productGroups.delete');

    Route::get('/admin/productKinds', [AdminController::class, 'productKind'])->name('admin.productKinds');
    Route::post('/admin/productKinds/create', [AdminController::class, 'productKindCreate'])->name('admin.productKinds.create');
    Route::put('/admin/productKinds/{id}', [AdminController::class, 'productKindUpdate'])->name('admin.productKinds.update');
    Route::delete('/admin/productKinds/{id}/delete', [AdminController::class, 'productKindDelete'])->name('admin.productKinds.create');

    Route::get('/admin/banner', [AdminController::class,'Banner'])->name('admin.banner');
    Route::put('/admin/banner/{id}/status', [AdminController::class, 'toggleBannerStatus'])->name('admin.toggleBannerStatus');
    Route::post('/admin/banner/create', [AdminController::class,'bannerAdd'])->name('admin.banner.create');
    Route::delete('/admin/banner/{id}/delete', [AdminController::class,'bannerDelete'])->name('admin.banner.delete');

    Route::get('/admin/news', [AdminController::class,'News'])->name('admin.news');
    Route::post('/admin/news/create', [AdminController::class,'NewsCreate'])->name('admin.news.create');
    Route::put('/admin/news/{id}/update', [AdminController::class,'NewsUpdate'])->name('admin.news.update');
    Route::delete('/admin/news/{id}/delete', [AdminController::class,'NewsDelete'])->name('admin.news.delete');
    Route::post('/admin/news/{id}/addPics', [AdminController::class, 'addNewsPictures'])->name('admin.addNewsPics');
    Route::delete('/admin/news/delete/image/{id}', [AdminController::class, 'deleteNewsPictures'])->name('admin.deleteNewsPics');
    Route::put('/admin/news/{id}/status', [AdminController::class, 'toggleNewsStatus'])->name('admin.toggleNewsStatus');


});
Route::middleware([
    'auth:sanctum',
    'roles:superadmin',
    'verified',
])->group(function () {
    Route::get('/admin/user', [AdminController::class, 'userAdmin'])->name('admin.userAdmin');
    Route::post('/admin/user/create', [AdminController::class, 'userAdd'])->name('admin.userAdmin.create');
    Route::delete('/admin/user/{id}/delete', [AdminController::class, 'userAdminDelete'])->name('admin.userAdmin.delete');
});


require __DIR__ . '/auth.php';
