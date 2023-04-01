<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["account_type" => "Discount"],
            ["account_type" => "General Income"],
            ["account_type" => "Interest Income"],
            ["account_type" => "Late Fee Income"],
            ["account_type" => "Sales"],
            ["account_type" => "Shipping Charge"],
            ["account_type" => "Other Charges"],
        ];
        AccountType::insert($data);
    }
}
