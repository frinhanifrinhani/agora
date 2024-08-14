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
        DB::table('users')->insert(
            [
                [
                    'name' => 'admin',
                    'cpf' => '12345678901',
                    'email' => 'administrdor@agora',
                    'password' => Hash::make('123456'),
                    'status' => true,
                    'role_id' => '1',
                ],
                [
                    'name' => 'user one',
                    'cpf' => '12345678902',
                    'email' => 'user.one@agora',
                    'password' => Hash::make('123456'),
                    'status' => true,
                    'role_id' => '2',
                ]
            ]
        );
    }
}
