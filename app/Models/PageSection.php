<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PageSection extends Model
{
    protected $fillable = ['page', 'section_key', 'label', 'value', 'media_url', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public static function getPage(string $page): Collection
    {
        return static::where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->mapWithKeys(fn ($section) => [
                $section->section_key => filled($section->value) ? $section->value : $section->media_url,
            ]);
    }
}
