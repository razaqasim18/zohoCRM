<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOtherDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'currency_id',
        'tax_id',
        'payment_term',
        'enable_portal',
        'opening_balance',
        'facebook_link',
        'twitter_link',
    ];
}
