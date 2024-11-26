<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("public\database\product_type.json");
        $productTypes = json_decode($json);
        foreach ($productTypes as $key => $value) {

            ProductType::create([
                "producttype_id" => $value->producttype_id,
                "producttype_name" => $value->producttype_name
            ]);

        }
    }
}
