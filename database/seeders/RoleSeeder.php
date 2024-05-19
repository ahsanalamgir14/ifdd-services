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
            ['name' => 'User', 'role_type' => 'user', 'country' => ''],
            ['name' => 'User Togo', 'role_type' => 'user', 'country' => 'Togo'],
            ['name' => 'User Benin', 'role_type' => 'user', 'country' => 'Benin'],
            ['name' => 'User Cameroun', 'role_type' => 'user', 'country' => 'Cameroun'],
            ['name' => 'User Senegal', 'role_type' => 'user', 'country' => 'Senegal'],
            ['name' => "User Cote d'ivoire", 'role_type' => 'user', 'country' => "Cote d'ivoire"],
            ['name' => 'User Tanzania', 'role_type' => 'user', 'country' => 'Tanzania'],
            ['name' => 'Client Togo', 'role_type' => 'client', 'country' => 'Togo'],
            ['name' => 'Client Benin', 'role_type' => 'client', 'country' => 'Benin'],
            ['name' => 'Client Cameroun', 'role_type' => 'client', 'country' => 'Cameroun'],
            ['name' => 'Client Senegal', 'role_type' => 'client', 'country' => 'Senegal'],
            ['name' => "Client Cote d'ivoire", 'role_type' => 'client', 'country' => "Cote d'ivoire"],
            ['name' => 'Client Tanzania', 'role_type' => 'client', 'country' => 'Tanzania'],
        ]);
    }
}
