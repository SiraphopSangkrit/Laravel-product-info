<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Inertia\Inertia;
use App\Models\ProductType;
class ProductController extends Controller
{
    public function index()
    {
        $product_types = ProductType::all();

        return Inertia::render('Main/main', [
            'product_types' =>  $product_types,
        ]);
    }
}
