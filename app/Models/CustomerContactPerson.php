<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContactPerson extends Model
{
    use HasFactory;
     protected $table = 'customer_contact_person';
    public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'salutation_id',
        'first_name',
        'last_name',
        'email',
        'contact_mobile',
        'company_name',
        'contact_phone',
        'designation',
        'department',
        'skype',
        'website',
    ];
}
