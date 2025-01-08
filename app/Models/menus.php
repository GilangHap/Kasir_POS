<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class menus extends Model
{
    protected $table = 'menus';
    protected $fillable = ['name', 'price', 'category_id', 'description', 'image'];
    
    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo('App\Models\menu_categories', 'category_id');
    }

    public function transaction_items()
    {
        return $this->hasMany('App\Models\transaction_items', 'menu_id');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
