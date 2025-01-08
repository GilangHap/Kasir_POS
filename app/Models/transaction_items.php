<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaction_items extends Model
{
    protected $table = 'transaction_items';
    protected $fillable = ['transaction_id', 'menu_id', 'quantity', 'price', 'total_price'];
    public $timestamps = true;

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transactions', 'transaction_id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Models\Menus', 'menu_id');
    }
}
