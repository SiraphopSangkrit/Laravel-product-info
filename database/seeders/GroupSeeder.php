<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;
use Illuminate\Support\Facades\File;
class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json = File::get("public\database\group type.json");
        $groups = json_decode($json);
        foreach ($groups as $key => $value) {

            Group::create([
                "group_id" => $value->group_id,
                "group_name" => $value->group_name
            ]);

        }
    }
}
