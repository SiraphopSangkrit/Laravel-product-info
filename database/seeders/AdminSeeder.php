<?php

namespace Database\Seeders;

use App\Models\TbUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Admin= TbUser::create([
            'username' => 'Admin',
            'firstname' => 'Web',
            'lastname' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt ('Admin1234')
        ]);
        $Admin->assignRole('superadmin');
    }
}
