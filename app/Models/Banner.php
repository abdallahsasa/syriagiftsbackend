<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'cta_text',
        'image_url',
        'link_url',
        'type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'cta_text' => 'array',
        'is_active' => 'boolean',
    ];
}
