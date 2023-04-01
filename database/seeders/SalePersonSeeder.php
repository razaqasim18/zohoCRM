<?php

namespace Database\Seeders;

use App\Models\SalesPerson;
use Illuminate\Database\Seeder;

class SalePersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalesPerson::insert([
            "business_id" => '1',
            "name" => "Sale person",
            "email" => "saleperson@saleperson.com",
        ]);
    }
}
