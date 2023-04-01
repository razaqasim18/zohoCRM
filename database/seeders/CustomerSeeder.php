<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::insert([
            'salutation_id' => '1',
            'business_id' => '1',
            'first_name' => 'customer',
            'last_name' => 'customer',
            'email' => 'customer@customer',
            'display_name' => 'customer',
        ]);
    }
}
