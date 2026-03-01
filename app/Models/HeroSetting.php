<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSetting extends Model
{
    protected $fillable = [
        'role',
        'summary_id',
        'summary_en',
        'focus_text_id',
        'focus_text_en',
        'years_of_experience',
        'position_tags',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position_tags' => 'array',
        ];
    }

    public static function current(): self
    {
        return self::firstOrCreate([], [
            'role' => 'Software Engineer',
            'summary_id' => '',
            'summary_en' => '',
            'focus_text_id' => '',
            'focus_text_en' => '',
            'years_of_experience' => 0,
            'position_tags' => [],
        ]);
    }
}
