<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Brands;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("public\database\brand.json");
        $brands = json_decode($json);
        foreach ($brands as $key => $value) {

            Brands::create([
                "brand_id" => $value->brand_id,
                "brand_name" => $value->brand_name
            ]);

        }
    }
}
