<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Store a newly created testimonial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'content' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'photo_url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle photo upload or URL
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        } elseif ($request->filled('photo_url')) {
            $validated['photo'] = $request->photo_url;
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = true;

        // Remove photo_url from validated (not a column)
        unset($validated['photo_url']);

        Testimonial::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Testimonial berhasil ditambahkan!');
    }

    /**
     * Update the specified testimonial.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'content' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'photo_url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle photo upload or URL
        if ($request->hasFile('photo')) {
            // Delete old photo from storage if it exists and is not a URL
            if ($testimonial->photo && !str_starts_with($testimonial->photo, 'http')) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $validated['photo'] = $request->file('photo')->store('testimonials', 'public');
        } elseif ($request->filled('photo_url')) {
            // Delete old photo from storage if it exists and is not a URL
            if ($testimonial->photo && !str_starts_with($testimonial->photo, 'http')) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $validated['photo'] = $request->photo_url;
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Remove photo_url from validated (not a column)
        unset($validated['photo_url']);

        $testimonial->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Testimonial berhasil diperbarui!');
    }

    /**
     * Toggle active status of a testimonial (AJAX).
     */
    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $testimonial->is_active,
            'message' => $testimonial->is_active ? 'Testimonial diaktifkan' : 'Testimonial dinonaktifkan',
        ]);
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete photo from storage if it exists and is not a URL
        if ($testimonial->photo && !str_starts_with($testimonial->photo, 'http')) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Testimonial berhasil dihapus!');
    }
}
