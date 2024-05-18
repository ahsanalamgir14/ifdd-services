<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::insert([
            ['name' => 'Admin', 'role_type' => 'super-admin'],
            ['name' => 'User', 'role_type' => 'user'],
            ['name' => 'User Togo', 'role_type' => 'user'],
            ['name' => 'User Benin', 'role_type' => 'user'],
            ['name' => 'User Cameroun', 'role_type' => 'user'],
            ['name' => 'User Senegal', 'role_type' => 'user'],
            ['name' => "User Cote d'ivoire", 'role_type' => 'user'],
            ['name' => 'User Tanzania', 'role_type' => 'user'],
            ['name' => 'Client Togo', 'role_type' => 'client'],
            ['name' => 'Client Benin', 'role_type' => 'client'],
            ['name' => 'Client Cameroun', 'role_type' => 'client'],
            ['name' => 'Client Senegal', 'role_type' => 'client'],
            ['name' => "Client Cote d'ivoire", 'role_type' => 'client'],
            ['name' => 'Client Tanzania', 'role_type' => 'client'],
        ]);
    }
}
