<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Update the banner for a specific page.
     */
    public function update(Request $request, $page_name)
    {
        // Deteksi jika server menolak request karena post_max_size terlampaui
        // Biasanya $_POST dan $_FILES akan kosong
        if ($request->isMethod('put') && empty($request->all()) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
            return redirect()->back()->with('error', 'Gagal mengunggah foto. Ukuran file terlalu besar melampaui batas server (post_max_size).');
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'text_color' => 'nullable|string|max:20', // e.g. #FFFFFF or text-white
            'image_url_type' => 'nullable|in:file,url',
            'image_url' => 'nullable|url',
        ]);
        
        $banner = Banner::where('page_name', $page_name)->firstOrFail();
        
        // Cek spesifik jika upload gagal karena batasan lain (misal upload_max_filesize)
        if ($request->has('image_path') && $request->file('image_path') && !$request->file('image_path')->isValid()) {
            return redirect()->back()->with('error', 'Gagal mengunggah foto. Ukuran foto terlalu besar (batas upload_max_filesize server) atau file rusak.');
        }

        // Handle Image Upload or URL
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists in storage (not if it's a seed or url)
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
            
            $path = $request->file('image_path')->store('banners', 'public');
            $banner->image_path = $path;
        } elseif ($request->input('image_url_type') === 'url' && $request->filled('image_url')) {
             $banner->image_path = $request->image_url;
        }

        $banner->title = $request->input('title');
        $banner->subtitle = $request->input('subtitle');
        $banner->text_color = $request->input('text_color');
        $banner->save();

        return redirect()->back()->with('success', 'Banner updated successfully!');
    }
}
