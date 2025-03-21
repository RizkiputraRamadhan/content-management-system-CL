<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';
    protected $guarded = [''];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
