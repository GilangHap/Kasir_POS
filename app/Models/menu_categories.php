<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class menu_categories extends Model
{
    protected $table = 'menu_categories';
    protected $fillable = ['name'];
    public $timestamps = true;

    public function menus()
    {
        return $this->hasMany('App\Models\Menus', 'category_id');
    }

    public function getMenuCountAttribute()
    {
        return $this->menus()->count();
    }
}
