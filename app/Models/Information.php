<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'information';

    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        'type',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the user who created this information.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}