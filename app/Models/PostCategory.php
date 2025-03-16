<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $fillable = ['slug','name'];

    public function posts() {
        return $this->hasMany(Posts::class, 'category_id');
    }
}