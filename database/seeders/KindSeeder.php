<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Kind;

class KindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("public\database\kind_type.json");
        $kinds = json_decode($json);
        foreach ($kinds as $key => $value) {

            Kind::create([
                "kind_id" => $value->kind_id,
                "kind_name" => $value->kind_name
            ]);

        }
    }
}
