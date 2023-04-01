<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::insert([
            'business_id' => '1',
            'unit_id' => '1',
            'tax_id' => '1',
            'account_type_id' => '1',
            'name' => 'Camera',
            'selling_price' => '100',
        ]);
    }
}
