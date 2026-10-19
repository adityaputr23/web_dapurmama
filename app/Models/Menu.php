<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'image_path',
        'badge',
        'tags',
        'category',
        'rating',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'tags'        => 'array',
        'is_featured' => 'boolean',
    ];
}
