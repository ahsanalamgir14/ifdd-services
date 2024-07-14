<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@kixafrique21.org',
                'password' => Hash::make('secret'),
                'email_verified_at' => now(),
                'role' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
