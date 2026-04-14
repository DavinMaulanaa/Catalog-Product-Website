<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            // If it starts with http, it's an external URL
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            // If it starts with img/, it's a local asset
            if (str_starts_with($this->image, 'img/')) {
                return asset($this->image);
            }
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Scope to get only active collections.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
