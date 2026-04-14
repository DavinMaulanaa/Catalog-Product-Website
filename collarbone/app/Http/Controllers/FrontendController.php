<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Collection;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Homepage / Dashboard frontend.
     */
    public function index()
    {
        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->get();

        $collections = Collection::active()
            ->orderBy('sort_order')
            ->get();

        $heroSlides = \App\Models\HeroSlide::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('welcome', compact('testimonials', 'collections', 'heroSlides', 'featuredProducts'));
    }

    /**
     * New Arrivals page.
     */
    
    public function newArrivals(Request $request)
    {
        $query = Product::where('is_new_arrival', true)
            ->where('is_active', true)
            ->with('category');

        $sort = $request->query('sort', 'latest');

        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->orderByRaw('sort_order = 0, sort_order')->latest();
                break;
        }

        $products = $query->get();

        $banner = \App\Models\Banner::firstOrCreate(
            ['page_name' => 'new_arrivals'],
            [
                'image_path' => 'img/Wallpaper.jpeg',
                'title' => 'FRESH DROPS',
                'subtitle' => 'Discover the latest additions to our collection.',
                'text_color' => '#FFFFFF'
            ]
        );

        return view('frontend.new_arrivals', compact('products', 'banner'));
    }

    /**
     * Categories page.
     */
    public function categories()
    {
        $categories = \App\Models\Category::where('is_active', true)
            ->with(['products' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('sort_order', 'asc')
            ->get();

        $banner = \App\Models\Banner::firstOrCreate(
            ['page_name' => 'categories'],
            [
                'image_path' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=1920&q=80',
                'title' => 'THE ARCHIVE',
                'subtitle' => 'Welcome to the complete catalog. Explore our dedicated collections of premium streetwear essentials and exclusive accessories.',
                'text_color' => '#FFFFFF'
            ]
        );

        return view('frontend.categories', compact('categories', 'banner'));
    }
}
