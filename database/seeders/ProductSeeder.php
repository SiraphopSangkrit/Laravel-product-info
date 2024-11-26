<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Products;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("public\database\product.json");
        $products = json_decode($json);
        foreach ($products as $key => $value) {
            Products::create([
                "product_id" => $value->product_id,
                "producttype_id" => $value->producttype_id,
                "product_name" => $value->product_name,
                "product_desc" => $value->product_desc,
                "product_desc0" => $value->product_desc0,
                "product_desc1" => $value->product_desc1,
                "brand_id" => $value->brand_id,
                "group_id" => $value->group_id,
                "kind_id" => $value->kind_id,
                "product_price" => $value->product_price,
                "product_proprice" => $value->product_proprice,
                "product_status" => '1'
            ]);

        }
    }
}
