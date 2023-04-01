<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'attention',
        'country_id',
        'address',
        'city',
        'state',
        'zip',
        'mobile',
        'fax',
        'is_shipping',
    ];
}
