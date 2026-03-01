<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'site_title',
        'meta_description',
        'meta_keywords',
        'og_image_path',
    ];

    public static function current(): self
    {
        return self::firstOrCreate([], [
            'site_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'og_image_path' => '',
        ]);
    }
}
