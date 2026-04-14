<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class NewArrivalsProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define Categories
        $categories = [
            'T-SHIRTS' => ['description' => 'Casual t-shirts and comfort wear.'],
            'HOODIES' => ['description' => 'Comfortable and warm hoodies.'],
            'SWEATSHIRTS' => ['description' => 'Stylish sweatshirts for any occasion.'],
        ];

        foreach ($categories as $name => $data) {
            Category::updateOrCreate(['name' => $name], ['description' => $data['description']]);
        }
        
        // Define Products based on USER HTML
        $products = [
            [
                'name' => 'Essential Oversized Tee',
                'category_name' => 'T-SHIRTS',
                'description' => 'Signature oversized fit tee crafted from heavyweight cotton jersey. Features dropped shoulders and a ribbed crewneck for a relaxed, modern silhouette.',
                'price' => 450000,
                'images' => ['img/7_DEPAN.png', 'img/7_BELAKANG.png'],
                'colors' => ['Black', 'White'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'is_new_arrival' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Cream Oversized Hoodie',
                'category_name' => 'HOODIES',
                'description' => 'Premium heavyweight fleece hoodie in a relaxed oversized cut. Double-layered hood and kangaroo pocket for maximum comfort and style.',
                'price' => 750000,
                'images' => ['img/5_DEPAN.png', 'img/5_BELAKANG.png'],
                'colors' => ['Cream'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'is_new_arrival' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Boxy Fit Tee',
                'category_name' => 'T-SHIRTS',
                'description' => 'Boxy silhouette tee with a cropped length. Garment-dyed for a vintage feel and soft hand-touch. Perfect for layering.',
                'price' => 490000,
                'images' => ['img/4.png', 'img/3_DEPAN.png'],
                'colors' => ['Charcoal'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'is_new_arrival' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Essential Sweatshirt',
                'category_name' => 'SWEATSHIRTS',
                'description' => 'Classic crewneck sweatshirt reimagined with a modern loose fit. Constructed from French Terry cotton with durable ribbed trims.',
                'price' => 650000,
                'images' => ['img/1.png', 'img/2_DEPAN.png'],
                'colors' => ['Grey', 'Black'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'is_new_arrival' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Vintage Wash Tee',
                'category_name' => 'T-SHIRTS',
                'description' => 'Achieve the perfect lived-in look with our Vintage Wash Tee. Softened fabric and unique color treatments make each piece unique.',
                'price' => 450000,
                'images' => ['img/3_DEPAN.png', 'img/3_BELAKANG.png'],
                'colors' => ['Black'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'is_new_arrival' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Striped Daily Tee',
                'category_name' => 'T-SHIRTS',
                'description' => 'A versatile staple for any wardrobe. This striped tee features a comfortable regular fit and is made from breathable cotton.',
                'price' => 350000,
                'images' => ['img/8.png', 'img/2_DEPAN.png'],
                'colors' => ['White', 'Blue'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'is_new_arrival' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Graphic Long Sleeve',
                'category_name' => 'T-SHIRTS',
                'description' => 'Statement long sleeve tee featuring bold graphic prints. Perfect for transitional weather and layering under jackets.',
                'price' => 550000,
                'images' => ['img/9.png', 'img/2_BELAKANG.png'],
                'colors' => ['Black', 'Grey'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'is_new_arrival' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Signature Logo Tee',
                'category_name' => 'T-SHIRTS',
                'description' => 'Our iconic logo tee. Clean, minimal, and essential. Made from 100% organic cotton for everyday comfort.',
                'price' => 450000,
                'images' => ['img/4.png', 'img/1.png'],
                'colors' => ['White'],
                'sizes' => ['S', 'M', 'L', 'XL'],
                'is_new_arrival' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $pData) {
            $cat = Category::where('name', $pData['category_name'])->first();

            Product::updateOrCreate(
                ['name' => $pData['name']],
                [
                    'category_id' => $cat->id,
                    'description' => $pData['description'],
                    'price' => $pData['price'],
                    'stock' => 50,
                    'sku' => 'SKU-' . strtoupper(str_replace(' ', '', substr($pData['name'], 0, 5))) . rand(100, 999),
                    'images' => $pData['images'], // Array of images
                    'colors' => $pData['colors'],
                    'sizes' => $pData['sizes'],
                    'is_active' => true,
                    'is_new_arrival' => $pData['is_new_arrival'],
                    'is_featured' => $pData['is_featured'],
                ]
            );
        }
    }
}
