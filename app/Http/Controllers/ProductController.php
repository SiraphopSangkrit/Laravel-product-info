<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Inertia\Inertia;
use App\Models\ProductType;
use App\Models\Products;

class ProductController extends Controller
{
    public function index()
    {
        $product_types = ProductType::all();
        $products = Products::with('kinds', 'groups', 'brands', 'types', 'productPics')->where('product_status',1)->paginate(40);
        return Inertia::render('Main/main', [
            'product_types' =>  $product_types,
            'products' => $products
        ]);
    }
}
