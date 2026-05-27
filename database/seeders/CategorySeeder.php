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
    }
}
