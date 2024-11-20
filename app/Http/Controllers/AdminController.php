<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ProductType;
use App\Models\Group;
use App\Models\Kind;
use App\Models\Products;
use App\Models\Brands;
use Illuminate\Support\Facades\Storage;


use App\Models\ProductPictures;

class AdminController extends Controller
{
    public function dashboard()
    {

        return Inertia::render('Admin/Dashboard', []);
    }

    public function products(Request $request)
    {
        $products = Products::with('kinds', 'groups', 'brands', 'types', 'productPics')->orderBy('producttype_id','asc')->paginate(36);
        $productKinds = Kind::all();
        $productTypes = ProductType::all();
        $productBrands = Brands::all();
        $productGroups = Group::all();

        return Inertia::render('Admin/Products', [
            'products' => $products,
            'productKinds' => $productKinds,
            'productTypes' => $productTypes,
            'productGroups' => $productGroups,
            'productBrands' => $productBrands,

        ]);
    }

    public function toggleStatus(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $product->product_status = $request->status;
        $product->save();

        return redirect()->back();
    }

    public function createProduct(Request $request)
    {
        $product = new Products;
        $product->product_id = $request->product_id;
        $product->product_name = $request->product_name;
        $product->product_desc = $request->product_desc;
        $product->product_desc0 = $request->product_desc0;
        $product->product_desc1 = $request->product_desc1;
        $product->producttype_id = $request->producttype_id;
        $product->brand_id = $request->brand_id;
        $product->group_id = $request->group_id;
        $product->kind_id = $request->kind_id;
        $product->product_price = $request->product_price;
        $product->product_proprice = '0';
        $product->save();



        return redirect()->back();
    }
    public function updateProduct(Request $request)
    {

        $productId = $request->product_id_edit;

        $product = Products::findOrFail($productId);
        $product->product_name = $request->product_name_edit;
        $product->product_desc = $request->product_desc_edit;
        $product->product_desc0 = $request->product_desc0_edit;
        $product->product_desc1 = $request->product_desc1_edit;
        $product->producttype_id = $request->producttype_id_edit;
        $product->brand_id = $request->brand_id_edit;
        $product->group_id = $request->group_id_edit;
        $product->kind_id = $request->kind_id_edit;
        $product->product_price = $request->product_price_edit;
        $product->save();

        return redirect()->back();
    }

    public function addPictures(Request $request)
    {
        $product_id = $request->product_id;

        $images = $request->file('image');

        foreach ($images as $image) {
            $product_pic = new ProductPictures;
            $product_pic->product_id = $product_id;
            $picture_path = $image->store('products_image', 'public');
            $product_pic->asset_url = $picture_path;
            $product_pic->public_url = $picture_path;
            $product_pic->save();
        }
    }

    public function deleteProductPictures(Request $request, $id)
    {


        $picture = ProductPictures::find($id);

        if ($picture) {
            Storage::disk('public')->delete($picture->asset_url);
            $picture->delete();
        }
    }

    public function productBrand(Request $request)
    {
        $productBrands = Brands::orderBy('brand_id')->paginate(10);

        return Inertia::render('Admin/ProductBrands', [
            'productBrands' => $productBrands
        ]);
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

    public function Banner(Request $request){

        return Inertia::render('Admin/Banner', [

        ]);
    }

    public function News(Request $request){

        return Inertia::render('Admin/News', [

        ]);
    }
}
