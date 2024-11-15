<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ProductType;
use App\Models\Group;
use App\Models\Kind;

class AdminController extends Controller
{
    public function dashboard()
    {

        return Inertia::render('Admin/Dashboard', []);
    }

    public function products(Request $request)
    {
        return Inertia::render('Admin/Products', []);
    }

    public function productType(Request $request)
    {
        $productTypes = ProductType::orderBy('producttype_id')->paginate(6);

        return Inertia::render('Admin/ProductType', [
            'productTypes' => $productTypes
        ]);
    }

    public function productGroup(Request $request)
    {
        $productGroups = Group::orderBy('group_id')->paginate(10);

        return Inertia::render('Admin/ProductGroups', [
            'productGroups' => $productGroups
        ]);
    }
    public function productKind(Request $request)
    {
        $productKinds = Kind::orderBy('kind_id')->paginate(15);

        return Inertia::render('Admin/ProductKind', [
            'productKinds' => $productKinds
        ]);
    }
}
