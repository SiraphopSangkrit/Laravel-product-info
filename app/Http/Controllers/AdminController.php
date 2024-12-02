<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ProductType;
use App\Models\Group;
use App\Models\Kind;
use App\Models\Products;
use App\Models\Brands;
use App\Models\Banners;
use App\Models\News;
use App\Models\NewsPics;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


use App\Models\ProductPictures;
use App\Models\TbUser;

class AdminController extends Controller
{
    public function dashboard()
    {

        return Inertia::render('Admin/Dashboard', []);
    }

    public function products(Request $request)
    {
        $search = $request->input('search');
        $products = Products::query()->with('kinds', 'groups', 'brands', 'types', 'productPics')
            ->when($search, function ($query, $search) {
                $query->where('product_name', 'LIKE', "%{$search}%")
                    ->orWhere('product_id', 'LIKE', "%{$search}%")
                    ->orWhereHas('brands', fn($q) => $q->where('brand_name', 'LIKE', "%{$search}%"))
                    ->orWhereHas('groups', fn($q) => $q->where('group_name', 'LIKE', "%{$search}%"))
                    ->orWhereHas('kinds', fn($q) => $q->where('kind_name', 'LIKE', "%{$search}%"))
                    ->orWhereHas('types', fn($q) => $q->where('producttype_name', 'LIKE', "%{$search}%"));
            })
            ->orderBy('product_id', 'asc')
            ->paginate(36)->withQueryString();



        return Inertia::render('Admin/Products', [
            'products' => $products,
            'productKinds' => Kind::all(),
            'productTypes' => ProductType::all(),
            'productGroups' => Group::all(),
            'productBrands' => Brands::all(),
            'search' => $search,
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

        $request->validate([
            'product_id' => 'required|unique:products|max:11|min:11',
            'product_name' => 'required',
            'product_desc' => 'required',
            'producttype_id' => 'required',
            'brand_id' => 'required',
            'group_id' => 'required',
            'kind_id' => 'required',
            'product_price' => 'required|numeric',
        ], [

            'product_id.required' => 'กรุณาใส่รหัสกลุ่มสินค้า.',
            'product_id.unique' => 'รหัสกลุ่มสินค้าซ้ำ กรุณาใส่รหัสกลุ่มสินค้าใหม่.',
            'product_id.max' => 'ใส่รหัสกลุ่มสินค้าได้ไม่เกิน 11 ตัว.',
            'product_id.min' => 'ใส่รหัสกลุ่มสินค้าได้ไม่ต่ำกว่า 11 ตัว.',
            'product_name.required' => 'กรุณาใส่ชื่อสินค้า.',
            'producttype_id.required' => 'กรุณาใส่ประเภทสินค้า.',
            'brand_id.required' => 'กรุณาใส่แบรนด์สินค้า.',
            'group_id.required' => 'กรุณาใส่ลุ่มสินค้า.',
            'kind_id.required' => 'กรุณาใส่ชนิดสินค้า.',
            'product_price.required' => 'กรุณาใส่รหัสกลุ่มสินค้า.',
            'product_price.numeric' => 'กรุณาใส่ตัวเลข.',

        ]);

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
    public function deleteProduct(Request $request)
    {

        $productId = $request->id;
        $product = Products::findOrFail($productId);
        $product->delete();


        return redirect()->back();
    }



    public function addProductPictures(Request $request)
    {

        $product_id = $request->product_id;

        $images = $request->file('image');
        if ($images) {
            foreach ($images as $image) {
                $product_pic = new ProductPictures;
                $product_pic->product_id = $product_id;
                $picture_path = $image->store('products_image', 'public');
                $product_pic->asset_url = $picture_path;
                $product_pic->public_url = $picture_path;
                $product_pic->save();
            }
        }

        return redirect()->back();
    }

    public function deleteProductPictures(Request $request, $id)
    {


        $picture = ProductPictures::find($id);

        if ($picture) {
            Storage::disk('public')->delete($picture->asset_url);
            $picture->delete();
        }
        return redirect()->back();
    }



    public function productBrand(Request $request)
    {
        $search = $request->input('search');
        $productBrands = Brands::query()
            ->when($search, function ($query, $search) {
                $query->where('brand_id', 'LIKE', "%{$search}%")
                    ->orWhere('brand_name', 'LIKE', "%{$search}%");
            })
            ->orderBy('brand_id', 'asc')
            ->paginate(10)->withQueryString();

        return Inertia::render('Admin/ProductBrands', [
            'productBrands' => $productBrands,
            'search' => $search
        ]);
    }

    public function productBrandCreate(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|unique:brand|max:5'
        ], [

            'brand_id.required' => 'กรุณาใส่รหัสแบรนด์สินค้า.',
            'brand_id.unique' => 'รหัสแบรนด์สินค้าซ้ำ กรุณาใส่รหัสแบรนด์สินค้าใหม่.',
            'brand_id.max' => 'ใส่รหัสแบรนด์สินค้าได้ไม่เกิน 5 ตัว.',

        ]);

        $productBrand = Brands::create([
            'brand_id' => $request->brand_id,
            'brand_name' => $request->brand_name,
        ]);


        return redirect()->back();
    }
    public function productBrandUpdate(Request $request, $id)
    {
        $productBrand = Brands::find($id);
        $productBrand->brand_name = $request->brand_name;
        $productBrand->save();

        return redirect()->back();
    }
    public function productBrandDelete(Request $request, $id)
    {

        $productBrand = Brands::find($id);
        $productBrand->delete();

        return redirect()->back();
    }
    public function productType(Request $request)
    {
        $search = $request->input('search');
        $productTypes = ProductType::query()
            ->when($search, function ($query, $search) {
                $query->where('producttype_id', 'LIKE', "%{$search}%")
                    ->orWhere('producttype_name', 'LIKE', "%{$search}%");
            })
            ->orderBy('producttype_id', 'asc')
            ->paginate(6)->withQueryString();


        return Inertia::render('Admin/ProductType', [
            'productTypes' => $productTypes,
            'search' => $search
        ]);
    }
    public function productTypeCreate(Request $request)
    {
        $request->validate([
            'producttype_id' => 'required|unique:product_type|max:5'
        ], [

            'gproducttype_id.required' => 'กรุณาใส่รหัสประเภทสินค้า.',
            'producttype_id.unique' => 'รหัสประเภทสินค้าซ้ำ กรุณาใส่รหัสประเภทสินค้าใหม่.',
            'producttype_id.max' => 'ใส่รหัสประเภทสินค้าได้ไม่เกิน 5 ตัว.',

        ]);

        $productType = ProductType::create([
            'producttype_id ' => $request->producttype_id,
            'producttype_name' => $request->producttype_name,
        ]);

        return redirect()->back();
    }
    public function productTypeUpdate(Request $request)
    {
        $productTypeId = $request->producttype_id;
        $productType = ProductType::find($productTypeId);
        $productType->producttype_name = $request->producttype_name;
        $productType->save();

        return redirect()->back();
    }
    public function productTypeDelete(Request $request, $id)
    {
        $productType = ProductType::find($id);
        $productType->delete();

        return redirect()->back();
    }

    public function productGroup(Request $request)
    {
        $search = $request->input('search');
        $productGroups = Group::query()
            ->when($search, function ($query, $search) {
                $query->where('group_id', 'LIKE', "%{$search}%")
                    ->orWhere('group_name', 'LIKE', "%{$search}%");
            })
            ->orderBy('group_id', 'asc')
            ->paginate(10)->withQueryString();

        return Inertia::render('Admin/ProductGroups', [
            'productGroups' => $productGroups
        ]);
    }
    public function productGroupCreate(Request $request)
    {

        $request->validate([
            'group_id' => 'required|unique:group|max:5'
        ], [

            'group_id.required' => 'กรุณาใส่รหัสกลุ่มสินค้า.',
            'group_id.unique' => 'รหัสกลุ่มสินค้าซ้ำ กรุณาใส่รหัสกลุ่มสินค้าใหม่.',
            'group_id.max' => 'ใส่รหัสกลุ่มสินค้าได้ไม่เกิน 5 ตัว.',

        ]);

        $group = Group::create([
            'group_id ' => $request->group_id,
            'group_name' => $request->group_name,
        ]);

        return redirect()->back();
    }
    public function productGroupUpdate(Request $request)
    {
        $groupId = $request->group_id;
        $group = Group::find($groupId);
        $group->group_name = $request->group_name;
        $group->save();

        return redirect()->back();
    }

    public function productGroupDelete(Request $request, $id)
    {
        $group = Group::find($id);
        $group->delete();

        return redirect()->back();
    }
    public function productKind(Request $request)
    {
        $search = $request->input('search');
        $productKinds = Kind::query()
            ->when($search, function ($query, $search) {
                $query->where('kind_id', 'LIKE', "%{$search}%")
                    ->orWhere('kind_name', 'LIKE', "%{$search}%");
            })
            ->orderBy('kind_id', 'asc')
            ->paginate(15)->withQueryString();

        return Inertia::render('Admin/ProductKind', [
            'productKinds' => $productKinds,
            'search' => $search
        ]);
    }

    public function productKindCreate(Request $request)
    {

        $request->validate([
            'kind_id' => 'required|unique:kind|max:5'
        ], [

            'kind_id.required' => 'กรุณาใส่รหัสชนิดสินค้า.',
            'kind_id.unique' => 'รหัสชนิดสินค้าซ้ำ กรุณาใส่รหัสชนิดสินค้าใหม่.',
            'kind_id.max' => 'ใส่รหัสชนิดสินค้าได้ไม่เกิน 5 ตัว.',

        ]);

        $kind = Kind::create([
            'group_id ' => $request->group_id,
            'group_name' => $request->group_name,
        ]);



        return redirect()->back();
    }
    public function productKindUpdate(Request $request)
    {

        $kindId =  $request->kind_id;
        $kind = Kind::find($kindId);
        $kind->kind_name = $request->kind_name;
        $kind->save();

        return redirect()->back();
    }
    public function productKindDelete(Request $request, $id)
    {

        $kind = Kind::find($id);
        $kind->delete();

        return redirect()->back();
    }

    public function Banner()
    {
        $banners = Banners::orderBy('created_at')->paginate(10);

        return Inertia::render('Admin/Banner', ['banners' => $banners]);
    }
    public function toggleBannerStatus(Request $request, $id)
    {
        $banner = Banners::findOrFail($id);
        $banner->banner_status = $request->status;
        $banner->save();

        return redirect()->back();
    }

    public function bannerAdd(Request $request)
    {
        $images = $request->file('image');
        $banner = new Banners;
        $picture_path = $images->store('banner_image', 'public');
        $banner->asset_url = $picture_path;
        $banner->public_url = $picture_path;
        $banner->save();


        return redirect()->back();
    }

    public function bannerDelete(Request $request, $id)
    {

        $picture = Banners::find($id);

        if ($picture) {
            Storage::disk('public')->delete($picture->asset_url);
            $picture->delete();
        }

        return redirect()->back();
    }
    public function News(Request $request)
    {
        $search = $request->input('search');
        $news = News::query()->with('newsPics')
            ->when($search, function ($query, $search) {
                $query->where('news_name', 'LIKE', "%{$search}%")
                    ->orWhere('news_desc', 'LIKE', "%{$search}%");
            })
            ->orderBy('news_id', 'asc')
            ->paginate(10)->withQueryString();

        return Inertia::render('Admin/News', ['News' => $news, 'search' => $search]);
    }

    public function NewsCreate(Request $request)
    {

        $news = News::create($request->all());

        return redirect()->back();
    }
    public function NewsUpdate(Request $request)
    {
        $newsId = $request->news_id;
        $news = News::findOrFail($request->id);
        $news->update($request->all());
        return redirect()->back();
    }

    public function addNewsPictures(Request $request)
    {
        $news_id = $request->news_id;

        $images = $request->file('image');
        if ($images) {
            foreach ($images as $image) {
                $newsPic = new NewsPics;
                $newsPic->news_id = $news_id;
                $picture_path = $image->store('news_image', 'public');
                $newsPic->asset_url = $picture_path;
                $newsPic->public_url = $picture_path;
                $newsPic->save();
            }
        }
        return redirect()->back();
    }

    public function NewsDelete(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->back();
    }

    public function deleteNewsPictures(Request $request, $id)
    {
        $picture = NewsPics::find($id);

        if ($picture) {
            Storage::disk('public')->delete($picture->asset_url);
            $picture->delete();
        }
        return redirect()->back();
    }


    public function toggleNewsStatus(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->news_status = $request->status;
        $news->save();

        return redirect()->back();
    }
    public function userAdmin(Request $request)
    {

        $adminUsers = TbUser::role('admin')->get();
        return Inertia::render('Admin/User', [
            'adminUsers' => $adminUsers
        ]);
    }


    public function userAdd(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email'
        ], [

            'username.required' => 'กรุณาใส่ username.',
            'username.unique' => 'username ซ้ำ กรุณาใส่ username ใหม่.',
            'email.required' => 'กรุณาใส่ email.',
            'email.unique' => 'email ซ้ำ กรุณาใส่ email ใหม่.',
            'email.email' => 'ใส่เฉพาะ email'

        ]);

        $admin = new TbUser;
        $admin->username = $request->username;
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;
        $admin->password = bcrypt('tppsadmin1234');
        $admin->assignRole('admin');
        $admin->save();

        return redirect()->back();
    }

    public function userAdminDelete(Request $request)
    {

        $admin = TbUser::findOrFail($request->id);
        $admin->delete();


        return redirect()->back();
    }
}
