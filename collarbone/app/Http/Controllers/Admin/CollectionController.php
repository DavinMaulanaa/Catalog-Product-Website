<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    /**
     * Store a newly created collection.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'image_url' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle image upload or URL/path
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('collections', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->image_url;
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = true;

        // Remove image_url from validated (not a column)
        unset($validated['image_url']);

        Collection::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Collection berhasil ditambahkan!');
    }

    /**
     * Update the specified collection.
     */
    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'image_url' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle image upload or URL/path
        if ($request->hasFile('image')) {
            // Delete old image from storage if applicable
            if ($collection->image && !str_starts_with($collection->image, 'http') && !str_starts_with($collection->image, 'img/')) {
                Storage::disk('public')->delete($collection->image);
            }
            $validated['image'] = $request->file('image')->store('collections', 'public');
        } elseif ($request->filled('image_url')) {
            // Delete old image from storage if applicable
            if ($collection->image && !str_starts_with($collection->image, 'http') && !str_starts_with($collection->image, 'img/')) {
                Storage::disk('public')->delete($collection->image);
            }
            $validated['image'] = $request->image_url;
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Remove image_url from validated (not a column)
        unset($validated['image_url']);

        $collection->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Collection berhasil diperbarui!');
    }

    /**
     * Toggle active status of a collection (AJAX).
     */
    public function toggleStatus(Collection $collection)
    {
        $collection->update(['is_active' => !$collection->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $collection->is_active,
            'message' => $collection->is_active ? 'Collection diaktifkan' : 'Collection dinonaktifkan',
        ]);
    }

    /**
     * Remove the specified collection.
     */
    public function destroy(Collection $collection)
    {
        // Delete image from storage if applicable
        if ($collection->image && !str_starts_with($collection->image, 'http') && !str_starts_with($collection->image, 'img/')) {
            Storage::disk('public')->delete($collection->image);
        }

        $collection->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Collection berhasil dihapus!');
    }
}
