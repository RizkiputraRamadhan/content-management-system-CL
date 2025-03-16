<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumPhoto extends Model
{
    protected $table = 'albums_photo';
    protected $fillable = ['image', 'album_id'];

     /**
     * Get the user who created the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
