<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\Collection;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Testimonials
        $testimonials = [
            [
                'name' => 'Raka Pratama',
                'role' => 'Mahasiswa',
                'content' => 'Gokil sih ini cuttingan oversized-nya! Pas banget di badan, ga kayak karung. Bahannya juga adem parah, dipake seharian di Jakarta yang panas tetep nyaman. Fix bakal koleksi semua warnanya!',
                'photo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=150&q=80',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Salsabila Putri',
                'role' => 'Content Creator',
                'content' => 'Jujurly kaget banget sama kualitasnya. Kirain bakal biasa aja, taunya premium banget woi! Sablonannya juga rapi detailnya dapet banget. Buat ootd kece badai sih ini!',
                'photo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&q=80',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Desta Mahendra',
                'role' => 'Musician',
                'content' => 'Vibes-nya dapet banget bro. Desainnya simpel tapi statement abis. Buat manggung atau nongkrong santai masuk semua. Definisi \'less is more\' yang sebenernya. Solid!',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&q=80',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Indah Kusuma',
                'role' => 'Fashion Blogger',
                'content' => 'Sumpah ini hidden gem banget! Jahitannya rapi, fitting-nya on point. Susah nyari brand lokal yang quality control-nya seoke ini. Highly recommended buat kalian yang cari basic wear tapi tetep styling.',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&q=80',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                $testimonial
            );
        }

        // Seed Collections
        $collections = [
            [
                'title' => 'T-Shirt | Limited Edition',
                'subtitle' => 'CATEGORY',
                'image' => 'img/1.png',
                'link' => '#',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Pin Button',
                'subtitle' => 'CATEGORY',
                'image' => 'img/MerchBG.png',
                'link' => '#',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'T-Shirt',
                'subtitle' => 'CATEGORY',
                'image' => 'img/9.png',
                'link' => '#',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($collections as $collection) {
            Collection::updateOrCreate(
                ['title' => $collection['title']],
                $collection
            );
        }
    }
}
