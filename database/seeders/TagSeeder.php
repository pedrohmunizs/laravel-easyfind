<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Adulto', 'Infantil', 'Neutro', 'Masculino', 'Feminino', 'Para casa', 'Para escritório', 'Para viagem', 'Portátil',
            'Clássico', 'Moderno', 'Esportivo', 'Formal', 'Casual', 'Orgânico', 'Exclusivo', 'Pen drives', 'Smartphones', 'Laptops',
            'Teclados', 'Mouses', 'Fones de ouvido', 'Acessórios', 'Carregadores', 'Cabos', 'Cases', 'Capinhas', 'Fontes de alimentação',
            'Cozinha', 'Sala', 'Quarto', 'Lavanderia', 'Luminárias', 'Quadros', 'Toalhas', 'Panelas', 'Talheres', 'Copos', 'Eletrodomésticos',
            'Móveis', 'Equipamentos de camping', 'Acessórios de natação', 'Acessórios de ciclismo', 'Skates', 'Raquetes de tênis',
            'Equipamentos de musculação', 'Bolas', 'Bicicletas', 'Tênis', 'Bolsas', 'Chapéus', 'Óculos', 'Sandálias', 'Sapatos', 'Meias',
            'Roupas íntimas', 'Shorts', 'Blusas', 'Camisetas', 'Calças', 'Livros', 'Brinquedos', 'Jogos', 'Pet', 'Saúde', 'Musicas', 'Filmes',
            'Desenhos', 'Ferramentas', 'Construção', 'Beleza', 'Maquiagem', 'Alimentos', 'Nacionais', 'Importados', 'Eletrônicos', 'Frescos',
            'Orgânicos', 'Artesanais', 'Gourmet', 'Ecológicos', 'Veganos', 'Sem glúten', 'Sem lactose', 'Naturais', 'Higiene', 'Limpeza',
            'Moda', 'Esportivos', 'Decoração', 'Automóveis', 'Jardinagem', 'Bem-estar', 'Papelaria', 'Revistas'
        ];

        foreach($tags as $tag){
            DB::table('tags')->insert([
                'descricao' => $tag
            ]);
        }
    }
}
