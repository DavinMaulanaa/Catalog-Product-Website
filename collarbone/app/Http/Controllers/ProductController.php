<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            match ($request->status) {
                'active' => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'featured' => $query->where('is_featured', true),
                'new' => $query->where('is_new_arrival', true),
                default => null,
            };
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $products = $query->paginate(10);
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'colors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
        ]);

        // Handle multiple image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
        }

        // Parse colors and sizes from comma-separated strings
        $colors = !empty($validated['colors'])
            ? array_map('trim', explode(',', $validated['colors']))
            : [];

        $sizes = !empty($validated['sizes'])
            ? array_map('trim', explode(',', $validated['sizes']))
            : [];

        Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null,
            'sku' => $validated['sku'] ?? null,
            'stock' => $validated['stock'],
            'images' => $imagePaths,
            'colors' => $colors,
            'sizes' => $sizes,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
            'is_new_arrival' => $request->has('is_new_arrival'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing a product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'colors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
        ]);

        // Handle removing existing images
        $existingImages = $product->images ?? [];
        $removedImages = $request->input('remove_images', []);

        foreach ($removedImages as $img) {
            Storage::disk('public')->delete($img);
            $existingImages = array_filter($existingImages, fn($i) => $i !== $img);
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $existingImages[] = $image->store('products', 'public');
            }
        }

        // Parse colors and sizes
        $colors = !empty($validated['colors'])
            ? array_map('trim', explode(',', $validated['colors']))
            : [];

        $sizes = !empty($validated['sizes'])
            ? array_map('trim', explode(',', $validated['sizes']))
            : [];

        $product->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null,
            'sku' => $validated['sku'] ?? null,
            'stock' => $validated['stock'],
            'images' => array_values($existingImages),
            'colors' => $colors,
            'sizes' => $sizes,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
            'is_new_arrival' => $request->has('is_new_arrival'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Delete all images
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalCategories = Category::count();
        $newArrivals = Product::where('is_new_arrival', true)->count();
        $featuredProducts = Product::where('is_featured', true)->count();
        $lowStock = Product::where('stock', '<', 10)->where('is_active', true)->count();

        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        $categoriesWithCount = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get();

        // Testimonials & Collections for dashboard management
        $testimonials = Testimonial::orderBy('sort_order')->get();
        $collections = Collection::orderBy('sort_order')->get();
        $heroSlides = \App\Models\HeroSlide::orderBy('sort_order')->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'totalCategories',
            'newArrivals',
            'featuredProducts',
            'lowStock',
            'recentProducts',
            'categoriesWithCount',
            'testimonials',
            'collections',
            'heroSlides'
        ));
    }

    /**
     * New Arrivals Page
     */
    public function newArrivals(Request $request)
    {
        $totalProducts = Product::count();
        $inStock = Product::where('stock', '>', 0)->count();
        $lowStock = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        $totalValue = Product::all()->sum(function($product) {
            return $product->price * $product->stock;
        });

        $query = Product::where('is_new_arrival', true)->with('category');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $products = $query->orderByRaw('sort_order = 0, sort_order')->latest()->paginate(10);
        $categories = Category::where('is_active', true)->get();

        // Banner Data
        $banner = \App\Models\Banner::firstOrCreate(
            ['page_name' => 'new_arrivals'],
            [
                'image_path' => 'img/Wallpaper.jpeg',
                'title' => 'FRESH DROPS',
                'subtitle' => 'Discover the latest additions to our collection.',
                'text_color' => '#FFFFFF'
            ]
        );

        return view('admin.new_arrivals.index', compact(
            'products', 
            'categories', 
            'totalProducts', 
            'inStock', 
            'lowStock', 
            'totalValue',
            'banner'
        ));
    }

    /**
     * Return product data as JSON for AJAX modal editing.
     */
    public function apiShow(Product $product)
    {
        $product->load('category');
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'category_id' => $product->category_id,
            'category_name' => $product->category->name ?? '-',
            'description' => $product->description,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'sku' => $product->sku,
            'stock' => $product->stock,
            'images' => $product->image_urls,
            'colors' => $product->colors ?? [],
            'sizes' => $product->sizes ?? [],
            'is_active' => $product->is_active,
            'is_featured' => $product->is_featured,
            'is_new_arrival' => $product->is_new_arrival,
            'formatted_price' => $product->formatted_price,
            'thumbnail' => $product->thumbnail,
        ]);
    }

    /**
     * Toggle product active status (AJAX).
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return response()->json([
            'success' => true,
            'is_active' => $product->is_active,
            'message' => $product->is_active ? 'Produk diaktifkan!' : 'Produk dinonaktifkan!',
        ]);
    }

    /**
     * Toggle new arrival flag (AJAX).
     */
    public function toggleNewArrival(Product $product)
    {
        $product->update(['is_new_arrival' => !$product->is_new_arrival]);
        return response()->json([
            'success' => true,
            'is_new_arrival' => $product->is_new_arrival,
            'message' => $product->is_new_arrival ? 'Ditambahkan ke New Arrivals!' : 'Dihapus dari New Arrivals!',
        ]);
    }

    /**
     * Toggle featured flag (AJAX).
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        return response()->json([
            'success' => true,
            'is_featured' => $product->is_featured,
            'message' => $product->is_featured ? 'Ditambahkan ke Featured!' : 'Dihapus dari Featured!',
        ]);
    }


    /**
     * Update the sort order of a product.
     */
    public function updateSortOrder(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:products,id',
            'sort_order' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($validated['id']);
        $product->sort_order = $validated['sort_order'];
        $product->save();

        return response()->json(['success' => true]);
    }
}
