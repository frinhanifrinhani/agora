<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'=>'admin',
            'cpf' => '12345678901',
            'email' => 'administrdor@agora',
            'password' => Hash::make('123456'),
            'status' => true,
            'role_id' => '1',

        ]);

    }
}
