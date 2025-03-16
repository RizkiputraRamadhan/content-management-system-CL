<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus';
    protected $guarded = [''];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(Menus::class, 'parent_id');
    }

    public function submenus()
    {
        return $this->hasMany(Menus::class, 'parent_id');
    }
}
