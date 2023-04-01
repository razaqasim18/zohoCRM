<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'business_id',
        'is_business',
        'salutation_id',
        'first_name',
        'last_name',
        'email',
        'display_name',
        'mobile',
        'company_name',
        'phone',
        'designation',
        'department',
        'skype',
        'website',
        'remarks',
    ];
}
