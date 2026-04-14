<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::updateOrCreate(
            ['page_name' => 'new_arrivals'],
            [
                'image_path' => 'img/Wallpaper.jpeg',
                'title' => 'FRESH DROPS',
                'subtitle' => 'Discover the latest additions to our collection. Crafted for the modern urban explorer.',
                'text_color' => '#FFFFFF',
            ]
        );
    }
}
