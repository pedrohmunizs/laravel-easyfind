<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BandeiraMetodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 1,
            'fk_bandeira_pagamento' => 1
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 1,
            'fk_bandeira_pagamento' => 2
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 1,
            'fk_bandeira_pagamento' => 3
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 1,
            'fk_bandeira_pagamento' => 4
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 1,
            'fk_bandeira_pagamento' => 5
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 2,
            'fk_bandeira_pagamento' => 1
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 2,
            'fk_bandeira_pagamento' => 3
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 2,
            'fk_bandeira_pagamento' => 4
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 2,
            'fk_bandeira_pagamento' => 5
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 2,
            'fk_bandeira_pagamento' => 7
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 5,
            'fk_bandeira_pagamento' => 6
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 4,
            'fk_bandeira_pagamento' => 6
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 5,
            'fk_bandeira_pagamento' => 8
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 4,
            'fk_bandeira_pagamento' => 8
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 5,
            'fk_bandeira_pagamento' => 9
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 4,
            'fk_bandeira_pagamento' => 9
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 5,
            'fk_bandeira_pagamento' => 10
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 4,
            'fk_bandeira_pagamento' => 10
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 3,
            'fk_bandeira_pagamento' => 11
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 3,
            'fk_bandeira_pagamento' => 12
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 6,
            'fk_bandeira_pagamento' => 13
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 6,
            'fk_bandeira_pagamento' => 14
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 6,
            'fk_bandeira_pagamento' => 15
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 6,
            'fk_bandeira_pagamento' => 16
        ]);

        DB::table('bandeiras_metodos')->insert([
            'fk_metodo_pagamento' => 6,
            'fk_bandeira_pagamento' => 17
        ]);
    }
}
