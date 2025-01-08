<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promotions extends Model
{
    protected $table = 'promotions';
    protected $fillable = ['name', 'discount_type', 'discount_value', 'valid_from', 'valid_until'];
    public $timestamps = true;
    public function transactions()
    {
        return $this->hasMany('App\Models\transactions', 'promotion_id');
    }
}
