<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'nome'=>'Usuário',
            'descricao'=>'Usuário do site',
            'created_at'=>now()
        ]);
        DB::table('roles')->insert([
            'nome'=>'Administrador 1',
            'descricao'=>'Administrador do site',
            'created_at'=>now()
        ]);
    }
}
