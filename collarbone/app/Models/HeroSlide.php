<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'image_path',
        'title',
        'subtitle',
        'link',
        'sort_order',
        'is_active',
    ];

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
