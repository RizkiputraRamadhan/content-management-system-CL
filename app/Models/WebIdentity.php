<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebIdentity extends Model
{
    protected $table = 'web_identities';
    protected $fillable = [
        'web_name',
        'email',
        'domain',
        'phone_number',
        'facebook_link',
        'instagram_link',
        'youtube_link',
        'twitter_link',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'google_maps',
        'favicon',
        'logo',
        'status',
        'version',
    ];

    public $timestamps = true;

    protected $casts = [
        'status' => 'string',
    ];
}