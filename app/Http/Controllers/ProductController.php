<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Inertia\Inertia;
use App\Models\ProductType;
use App\Models\Products;
use App\Models\Banners;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $productTypes = ProductType::all();
        $banners = Banners::where('banner_status', 1)->get();

        return Inertia::render('Main/main', [
            'product_types' => $productTypes,
            'banners' => $banners,
        ]);
    }

    public function productCategory(Request $request, $id)
    {

        $productTypeId = $id;
        $productType = ProductType::find($id);
        $brandFilters = $request->input('brands');
        $kindFilters = $request->input('kinds');
        $groupFilters = $request->input('groups');

        $query = Products::query()->with('kinds', 'groups', 'brands', 'types', 'productPics')
            ->where('product_status', 1);


        if ($productTypeId) {
            $query->where('producttype_id', $productTypeId);
        }
        $productFilterOption = $query->get();
        $brands =  $productFilterOption->pluck('brands')->flatten()->unique('brand_id');
        $kinds = $productFilterOption->pluck('kinds')->flatten()->unique('kind_id');
        $groups = $productFilterOption->pluck('groups')->flatten()->unique('group_id');
        if ($brandFilters) {
            $brandIds = explode(',', $brandFilters);
            $query->whereHas('brands', function ($q) use ($brandIds) {
                $q->whereIn('brand_id', $brandIds);
            });
        }
        $groupsFilterOption = $query->get();
        $groups = $groupsFilterOption->pluck('groups')->flatten()->unique('group_id');
        if ($groupFilters) {
            $groupIds = explode(',', $groupFilters); // Convert comma-separated string to array
            $query->whereHas('groups', function ($q) use ($groupIds) {
                $q->whereIn('group_id', $groupIds);
            });
        }
        $kindsFilterOption = $query->get();
        $kinds = $kindsFilterOption->pluck('kinds')->flatten()->unique('kind_id');
        if ($kindFilters) {
            $kindIds = explode(',', $kindFilters); // Convert comma-separated string to array
            $query->whereHas('kinds', function ($q) use ($kindIds) {
                $q->whereIn('kind_id', $kindIds);
            });
        }


        $products = $query->paginate(40);

        $productTypes = ProductType::all();


        return Inertia::render('Main/categoryPage', [
            'product_types' => $productTypes,
            'productType' => $productType,
            'products' => $products,
            'brands' => $brands,
            'kinds' => $kinds,
            'groups' => $groups,
            'filters' => [
                'brands' => $brandFilters ? explode(',', $brandFilters) : [],
                'kinds' => $kindFilters ? explode(',', $kindFilters) : [],
                'groups' => $groupFilters ? explode(',', $groupFilters) : [],
            ],
        ]);
    }
}
