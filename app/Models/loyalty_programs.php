<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class loyalty_programs extends Model
{
    protected $table = 'loyalty_programs';
    protected $fillable = ['customer_name', 'customer_phone', 'points', 'last_transaction_id'];

    public function transactions()
    {
        return $this->hasMany('App\Models\transactions', 'user_id');
    }
}