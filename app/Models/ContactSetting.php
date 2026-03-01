<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'email',
        'github_url',
        'linkedin_url',
        'instagram_url',
        'recaptcha_site_key',
        'recaptcha_secret_key',
    ];

    public static function current(): self
    {
        return self::firstOrCreate([], [
            'email' => '',
            'github_url' => '',
            'linkedin_url' => '',
            'instagram_url' => '',
            'recaptcha_site_key' => '',
            'recaptcha_secret_key' => '',
        ]);
    }
}
