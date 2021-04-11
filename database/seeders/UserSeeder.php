<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'mobile'=> 9876543211,
            'password' => Hash::make('admin'),
            'total_qr' => 0,
            'total_hit' => 0,
            'role' => '0',
            'status' => 1,
        ]);
    }
}
