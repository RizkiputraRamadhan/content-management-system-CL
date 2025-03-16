<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    protected $table = 'post_tags';
    protected $fillable = ['slug','name'];

    static function tagById($id) {
        return static::find($id);
    }
}