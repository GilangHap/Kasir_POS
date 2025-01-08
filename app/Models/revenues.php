<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class revenues extends Model
{
    protected $table = 'revenues';
    protected $fillable = ['date', 'total_revenue', 'cash_revenue', 'digital_revenue'];
    public $timestamps = true;
}
