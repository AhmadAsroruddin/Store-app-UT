<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'product_category_id' => 1,
                'name' => 'Pop Corn',
                'price' => 60000,
                'image' => 'produk1.jpg',
                'description' => 'Pop corn caramel',
                'created_at' => now(),
            ],
            [
                'product_category_id' => 2,
                'name' => 'Milo Dino',
                'price' => 50000,
                'image' => 'produk2.jpg',
                'description' => 'Milo dengan campuran coklat lezat',
                'created_at' => now(),
            ],
        ]);
    }
}
