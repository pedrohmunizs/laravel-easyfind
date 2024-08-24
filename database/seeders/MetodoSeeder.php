<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodos = [
            'Cartão de crédito', 'Cartão de débito', 'Pagamento à vista', 'Vale alimentação', 'Vale refeição', 'Carteira digital'
        ];

        foreach($metodos as $metodo){
            DB::table('metodos_pagamento')->insert([
                'descricao' => $metodo
            ]);
        }
    }
}
