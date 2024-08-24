<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BandeiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Visa',
            'imagem' => 'visa.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Mastercard',
            'imagem' => 'mastercard.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Elo',
            'imagem' => 'elo.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'American Express',
            'imagem' => 'americanexpress.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Hipercard',
            'imagem' => 'hipercard.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Alelo',
            'imagem' => 'alelo.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Maestro',
            'imagem' => 'maestro.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Sodexo',
            'imagem' => 'sodexo.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Ticket',
            'imagem' => 'ticket.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'VR',
            'imagem' => 'vr.png'
        ]);
        
        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Dinheiro',
            'imagem' => 'dinheiro.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Pix',
            'imagem' => 'pix.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Mercado Pago',
            'imagem' => 'mercadopago.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'PagSeguro',
            'imagem' => 'pagseguro.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'PayPal',
            'imagem' => 'paypal.png'
        ]);
        
        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'PicPay',
            'imagem' => 'picpay.png'
        ]);

        DB::table('bandeiras_pagamento')->insert([
            'nome' => 'Ame',
            'imagem' => 'ame.png'
        ]);
    }
}
