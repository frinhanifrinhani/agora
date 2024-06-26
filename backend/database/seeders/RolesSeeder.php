<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name'=>'Usuário',
            'description'=>'Usuário do site',
            'created_at'=>now()
        ]);
        DB::table('roles')->insert([
            'name'=>'Administrador 1',
            'description'=>'Administrador do site',
            'created_at'=>now()
        ]);
    }
}
