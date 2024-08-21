<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->insert(
            [
                [
                    'title' => 'Feira de soluções 2024',
                    'body' => 'A Fiocruz Brasília e a Secretaria de Saúde do Distrito Federal (SES-DF) realizarão, de 12 a 14 de novembro, a 7ª edição da Feira de Soluções para a Saúde,
com o tema "ODS Conectados". Este evento, focado na perspectiva da Ciência Cidadã, apresentará propostas de soluções para a saúde nos eixos social, tecnológico e de serviços. O objetivo
é aproximar o universo científico de outros produtores de conhecimento, promovendo um diálogo enriquecedor e colaborativo sobre o tema.',
                    'alias' => 'feira_solucoes_2024',
                    'open_to_comments' => 0,
                    'publicated' => 0,
                    'publication_date' => '2024-08-07',
                    'user_id' => 1,
                ]
            ]
        );
    }
}