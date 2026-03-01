<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'long_description',
        'category',
        'live_preview_url',
        'github_url',
        'stacks',
        'key_features',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'stacks' => 'array',
            'key_features' => 'array',
        ];
    }

    /**
     * @return HasMany<PortfolioImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class)->orderBy('sort_order');
    }
}
