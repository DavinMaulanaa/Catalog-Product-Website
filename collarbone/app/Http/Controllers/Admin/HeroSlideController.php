<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('hero-slides', 'public');

        HeroSlide::create([
            'image_path' => $path,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->back()->with('success', 'Hero slide created successfully!');
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer',
        ]);

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'sort_order' => $request->sort_order ?? $heroSlide->sort_order,
        ];

        if ($request->hasFile('image')) {
            if ($heroSlide->image_path && Storage::disk('public')->exists($heroSlide->image_path)) {
                Storage::disk('public')->delete($heroSlide->image_path);
            }
            $data['image_path'] = $request->file('image')->store('hero-slides', 'public');
        }

        $heroSlide->update($data);

        return redirect()->back()->with('success', 'Hero slide updated successfully!');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image_path && Storage::disk('public')->exists($heroSlide->image_path)) {
            Storage::disk('public')->delete($heroSlide->image_path);
        }
        $heroSlide->delete();
        return redirect()->back()->with('success', 'Hero slide deleted successfully!');
    }

    public function toggleStatus(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => !$heroSlide->is_active]);
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'is_active' => $heroSlide->is_active
        ]);
    }
}
