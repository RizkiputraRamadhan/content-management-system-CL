<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';
    protected $fillable = ['name', 'slug', 'description', 'created_by'];

     /**
     * Get the user who created the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class, 'album_id');
    }
}
