<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'image_path',
        'link_url',
        'position',
        'sort_order',
        'is_active',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'sort_order' => 'integer',
        'is_active'  => 'boolean',
    ];

    /**
     * Scope lấy danh sách banner đang bật theo vị trí hiển thị.
     */
    public function scopeActive(Builder $query, string $position = 'home_hero'): Builder
    {
        return $query->where('is_active', true)
                     ->where('position', $position)
                     ->orderBy('sort_order', 'asc');
    }
}
