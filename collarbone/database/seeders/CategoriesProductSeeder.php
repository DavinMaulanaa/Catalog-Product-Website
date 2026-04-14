<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Categories Exist
        $tshirtCat = Category::firstOrCreate(
            ['name' => 'T-SHIRTS'],
            ['description' => 'Premium cotton t-shirts with modern cuts.']
        );

        $pinCat = Category::firstOrCreate(
            ['name' => 'PIN BUTTONS'],
            ['description' => 'Exclusive metal pin buttons.']
        );

        // 2. Seed T-Shirts (8 items)
        $tshirts = [
            [
                'name' => 'Oversized Tee',
                'price' => 185000,
                'image' => 'img/1.png',
                'description' => 'Premium heavyweight cotton tee with an oversized fit for maximum comfort and style.',
                'color' => 'Black', 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Graphic Tee',
                'price' => 195000,
                'image' => 'img/4.png',
                'description' => 'Featuring exclusive artwork printed on high-quality fabric. A statement piece for your wardrobe.',
                'color' => 'White', 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Vintage Wash',
                'price' => 210000,
                'image' => 'img/8.png',
                'description' => 'Soft, garment-dyed fabric for a vintage look and feel. Unique color treatment.',
                'color' => 'Grey', 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Essential Tee',
                'price' => 185000,
                'image' => 'img/2_DEPAN.png',
                'description' => 'A versatile staple for everyday wear. Made from breathable cotton.',
                'color' => 'Cream', 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Relaxed Fit',
                'price' => 195000,
                'image' => 'img/3_DEPAN.png',
                'description' => 'Comfortable relaxed fit for casual styling. Perfect for any occasion.',
                'color' => 'Navy', 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Pocket Tee',
                'price' => 175000,
                'image' => 'img/5_DEPAN.png',
                'description' => 'Classic tee with a functional chest pocket. Simple and practical.',
                'color' => 'Olive', 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Stripe Tee',
                'price' => 220000,
                'image' => 'img/7_DEPAN.png',
                'description' => 'Timeless striped pattern in soft cotton. Adds a pop of visual interest.',
                'color' => 'Blue', 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Classic Tee',
                'price' => 185000,
                'image' => 'img/9.png',
                'description' => 'The perfect everyday t-shirt. Soft, durable, and fits just right.',
                'color' => 'Charcoal', 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],
        ];

        foreach ($tshirts as $t) {
            Product::updateOrCreate(
                ['name' => $t['name'] . ' - ' . $t['color']], // Unique name to avoid dupes if seeded multiple times
                [
                    'category_id' => $tshirtCat->id,
                    'price' => $t['price'],
                    'description' => $t['description'],
                    'images' => [$t['image']], // Store as array
                    'colors' => [$t['color']],
                    'sizes' => $t['sizes'],
                    'stock' => 50,
                    'is_active' => true,
                    'is_new_arrival' => false,
                    'is_featured' => false,
                ]
            );
        }

        // 3. Seed Pin Buttons (3 items)
        $pins = [
            [
                'name' => 'Skull Pin',
                'price' => 45000,
                'image' => 'img/merchBG.png',
                'description' => 'Metal pin button with a unique skull design. Perfect for customizing your gear.',
            ],
            [
                'name' => 'Rose Pin',
                'price' => 45000,
                'image' => 'img/Merch-2.jpeg',
                'description' => 'Elegant rose design pin button. Adds a touch of floral style.',
            ],
            [
                'name' => 'Star Pin',
                'price' => 45000,
                'image' => 'img/merchBG.png',
                'description' => 'Classic star design pin button. A simple yet bold statement.',
            ],
        ];

        foreach ($pins as $p) {
             Product::updateOrCreate(
                ['name' => $p['name']],
                [
                    'category_id' => $pinCat->id,
                    'price' => $p['price'],
                    'description' => $p['description'],
                    'images' => [$p['image']],
                    'colors' => [], // Pins might not have color selection
                    'sizes' => [],  // Pins might not have sizes
                    'stock' => 100,
                    'is_active' => true,
                ]
            );
        }
    }
}
