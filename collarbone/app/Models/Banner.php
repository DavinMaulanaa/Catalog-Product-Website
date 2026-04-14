<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'image_path',
        'title',
        'subtitle',
        'text_color'
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return $this->getDefaultImage();
        }

        if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }

        // Check if it's in storage using Storage facade instead of file_exists on public_path symlink
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->image_path)) {
             return asset('storage/' . $this->image_path);
        }
        
        // Also check direct public path (e.g. 'img/...')
        if (file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }

        return $this->getDefaultImage();
    }

    private function getDefaultImage() {
        return $this->page_name === 'categories' 
            ? 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=1920&q=80'
            : asset('img/Wallpaper.jpeg');
    }
}
