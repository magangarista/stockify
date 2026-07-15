<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Produk elektronik dan gadget'],
            ['name' => 'Pakaian', 'description' => 'Baju, celana, dan aksesoris fashion'],
            ['name' => 'Makanan', 'description' => 'Produk makanan dan minuman'],
            ['name' => 'Alat Tulis Kantor', 'description' => 'Perlengkapan kantor dan sekolah'],
            ['name' => 'Perabotan Rumah Tangga', 'description' => 'Peralatan dan perlengkapan rumah tangga'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}