<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Inertia\Inertia;
use App\Models\ProductType;
use App\Models\Products;
use App\Models\Banners;
use App\Models\News;
use App\Models\NewsPics;
use App\Models\ProductPictures;
use Spatie\Searchable\Search;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $productTypes = ProductType::all();
        $banners = Banners::where('banner_status', 1)->get();
        $news = News::where('news_status', 1)->with('newsPics')->take(3)->orderBy('created_at', 'desc')->get();
        $products = Products::where('product_status', 1)->with('productPics')->take(6)->orderBy('created_at','desc')->get();

        return Inertia::render('Main/main', [
            'product_types' => $productTypes,
            'banners' => $banners,
            'news' => $news,
            'products'=> $products,
        ]);
    }

    public function productCategory(Request $request, $id)
    {
        $productTypeId = $id;
        $productType = ProductType::find($id);

        // Retrieve filters from the request
        $brandFilters = $request->input('brands', []);
        $kindFilters = $request->input('kinds', []);
        $groupFilters = $request->input('groups', []);

        // Ensure filters are arrays
        $brandFilters = is_string($brandFilters) ? explode(',', $brandFilters) : (array) $brandFilters;
        $kindFilters = is_string($kindFilters) ? explode(',', $kindFilters) : (array) $kindFilters;
        $groupFilters = is_string($groupFilters) ? explode(',', $groupFilters) : (array) $groupFilters;

        $query = Products::with('kinds', 'groups', 'brands', 'types', 'productPics')
            ->where('product_status', 1);

        if ($productTypeId) {
            $query->where('producttype_id', $productTypeId);
        }


        $productFilterOption = $query->get();
        $brands = $productFilterOption->pluck('brands')->flatten()->unique('brand_id');
        $kinds = $productFilterOption->pluck('kinds')->flatten()->unique('kind_id');
        $groups = $productFilterOption->pluck('groups')->flatten()->unique('group_id');

        if ($brandFilters) {
            $query->whereHas('brands', function ($q) use ($brandFilters) {
                $q->whereIn('brand_id', $brandFilters);
            });

            $brandFiltersOption = $query->get();
            $groups = $brandFiltersOption->pluck('groups')->flatten()->unique('group_id');
            $kinds = $brandFiltersOption->pluck('kinds')->flatten()->unique('kind_id');
        }


        if ($groupFilters) {
            $query->whereHas('groups', function ($q) use ($groupFilters) {
                $q->whereIn('group_id', $groupFilters);
            });
            $groupsFilterOption = $query->get();
            $brands = $groupsFilterOption->pluck('brands')->flatten()->unique('brand_id');
            $kinds = $groupsFilterOption->pluck('kinds')->flatten()->unique('kind_id');
        }

        if ($kindFilters) {
            $query->whereHas('kinds', function ($q) use ($kindFilters) {
                $q->whereIn('kind_id', $kindFilters);
            });

            $kindsFilterOption = $query->get();
            $brands = $kindsFilterOption->pluck('brands')->flatten()->unique('brand_id');
            $groups = $kindsFilterOption->pluck('groups')->flatten()->unique('group_id');
        }


        $products = $query->paginate(32);


        $products->appends([
            'brands' => implode(',', $brandFilters),
            'kinds' => implode(',', $kindFilters),
            'groups' => implode(',', $groupFilters),
        ]);


        $productTypes = ProductType::all();

        return Inertia::render('Main/categoryPage', [
            'product_types' => $productTypes,
            'productType' => $productType,
            'products' => $products,
            'brands' => $brands,
            'kinds' => $kinds,
            'groups' => $groups,
            'filters' => [
                'brands' => $brandFilters,
                'kinds' => $kindFilters,
                'groups' => $groupFilters,
            ],
        ]);
    }

    public function productDetail(Request $request)
    {
        $product_id = $request->product_id;
        $product = Products::findOrFail($product_id);
        $productPic = ProductPictures::where('product_id', $product_id)->get();
        $productTypes = ProductType::all();
        $brand = $product->brands;
        $kind = $product->kinds;
        $group = $product->groups;
        $type = $product->types;

        return Inertia::render('Main/productDetail', [
            'product_types' => $productTypes,
            'product' => $product,
            'productPic' => $productPic,
            'brand' => $brand,
            'kind' => $kind,
            'group' => $group,
            'type' => $type,
        ]);
    }
    public function newsList(Request $request)
    {
        $news = News::where('news_status', 1)->with('newsPics')->orderBy('created_at', 'desc')->paginate(10);
        $productTypes = ProductType::all();

        return Inertia::render('Main/newsList', [
            'news' => $news,
            'product_types' => $productTypes
        ]);
    }

    public function newsDetail(Request $request) {

        $newsId = $request->id;
        $news = News::find($newsId);
        $newsPicture= NewsPics::where('news_id', $newsId)->get();



        $productTypes = ProductType::all();
        return Inertia::render('Main/newsPage', [
            'news' => $news,
            'newsPicture' =>$newsPicture,
            'product_types' => $productTypes
        ]);
    }

    public function productSearch(Request $request)
    {
        try {
            // Get the search query
            $query = $request->input('searchQuery');
            if (empty($query)) {
                return response()->json([]);
            }
            $results = Products::where('product_name', 'like', "%$query%")->with('productPics')->take(5)->get();

            return response()->json($results);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Error in productSearch:', ['error' => $e->getMessage()]);

            // Return an error response
            return response()->json(['message' => 'An error occurred while searching products.'], 500);
        }
    }
}
