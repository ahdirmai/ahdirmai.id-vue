<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'organization_name',
        'position',
        'year',
        'sort_order',
    ];
}
