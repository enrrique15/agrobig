<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fertilizantes Foliares'],
            ['name' => 'Fertilizantes Nitrogenados'],
            ['name' => 'Fertilizantes a Base de Fosfatos'],
            ['name' => 'Fertilizantes a Base de Potasio'],
            ['name' => 'Fertilizantes de Base'],
            ['name' => 'Fertilizantes Micronutrientes'],
            ['name' => 'Coadyuvante Siliconado'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
