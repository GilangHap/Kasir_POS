<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['total_price', 'discount', 'final_price', 'payment_method', 'status', 'user_id', 'promotion_id',];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo('App\Models\users', 'user_id');
    }
    public function transaction_items()
    {
        return $this->hasMany('App\Models\transaction_items', 'transaction_id');
    }
    public function promotion()
    {
        return $this->belongsTo('App\Models\promotions', 'promotion_id');
    }
    public function loyalty_program()
    {
        return $this->belongsTo(loyalty_programs::class, 'user_id');
    }
}
