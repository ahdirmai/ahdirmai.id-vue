<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'name',
        'issued_by',
        'link',
        'sort_order',
    ];
}
