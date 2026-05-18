<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Price;
use Illuminate\Support\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear las Categorías y guardarlas en un array para usarlas luego
        $categoriesData = [
            'Fertilizantes Foliares',
            'Fertilizantes Nitrogenados',
            'Fertilizantes a Base de Fosfatos',
            'Fertilizantes a Base de Potasio',
            'Fertilizantes de Base',
            'Fertilizantes Micronutrientes',
            'Coadyuvante Siliconado',
        ];

        $createdCategories = [];
        foreach ($categoriesData as $name) {
            $createdCategories[$name] = Category::create(['name' => $name]);
        }

        // 2. Definir los Productos (Fertilizantes) basados en el índice IAF
        $productsData = [
            [
                'category' => 'Fertilizantes Nitrogenados',
                'name' => 'Urea',
                'description' => 'Fertilizante nitrogenado sólido de alta concentración. Ideal para mayor demanda.',
                'presentation' => 'Bolsa 50 kg',
                'abreviation' => 'UREA-50',
                'base_price' => 420, // Precio referencial inicial
            ],
            [
                'category' => 'Fertilizantes a Base de Fosfatos',
                'name' => 'DAP',
                'description' => 'Fosfato Diamónico. Mercado con poca variación actualmente.',
                'presentation' => 'Bolsa 50 kg',
                'abreviation' => 'DAP-50',
                'base_price' => 640,
            ],
            [
                'category' => 'Fertilizantes a Base de Fosfatos',
                'name' => 'MAP',
                'description' => 'Fosfato Monoamónico. Mejor oportunidad de compra por tendencia a la baja.',
                'presentation' => 'Bolsa 50 kg',
                'abreviation' => 'MAP-50',
                'base_price' => 610,
            ],
            [
                'category' => 'Fertilizantes a Base de Potasio',
                'name' => 'KCl (Cloruro de Potasio)',
                'description' => 'Alta demanda en soya, maíz y caña.',
                'presentation' => 'Bolsa 50 kg',
                'abreviation' => 'KCL-50',
                'base_price' => 370,
            ],
            [
                'category' => 'Fertilizantes Nitrogenados',
                'name' => 'Sulfato de Amonio',
                'description' => 'Buen momento para planificar compras. Tendencia estable.',
                'presentation' => 'Bolsa 50 kg',
                'abreviation' => 'SAM-50',
                'base_price' => 310,
            ],
            [
                'category' => 'Fertilizantes Micronutrientes',
                'name' => 'Nitrato de Calcio',
                'description' => 'Demanda creciente en frutales y hortalizas.',
                'presentation' => 'Bolsa 25 kg',
                'abreviation' => 'NCAL-25',
                'base_price' => 720,
            ],
        ];

        // 3. Registrar los productos y generar la gráfica de precios
        foreach ($productsData as $data) {
            // Insertar el producto respetando tus campos exactos
            $product = Product::create([
                'category_id' => $createdCategories[$data['category']]->id,
                'name' => $data['name'],
                'description' => $data['description'],
                'image' => null,
                'presentation' => $data['presentation'],
                'abreviation' => $data['abreviation'],
                'stock' => rand(100, 1000), // Inventario inicial aleatorio
            ]);

            // 4. Generar el historial de precios para la gráfica (Últimos 60 días)
            $timeline = Carbon::now()->subDays(60);
            $currentPrice = $data['base_price'];

            // Creamos 15 puntos de datos (precios) por cada fertilizante
            for ($i = 0; $i < 15; $i++) {
                // Avanzamos entre 3 y 4 días en el tiempo
                $timeline->addDays(rand(3, 4));

                // Fluctuación realista del mercado (Sube o baja entre -10 y +15)
                $fluctuation = rand(-10, 15);
                $currentPrice += $fluctuation;

                // Evitar que el precio caiga de forma irreal
                if ($currentPrice < 100) {
                    $currentPrice = 100;
                }

                // Insertar el precio histórico
                Price::create([
                    'product_id' => $product->id,
                    'price' => $currentPrice,
                    'effective_date' => $timeline->copy(),
                ]);
            }
        }
    }
}