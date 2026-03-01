<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = [
        'university',
        'degree_id',
        'degree_en',
        'gpa',
        'awards',
        'research_title',
        'research_link',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'awards' => 'array',
            'gpa' => 'decimal:2',
        ];
    }
}
