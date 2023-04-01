<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["unit_name" => "box", "unit" => "box"],
            ["unit_name" => "centimeter", "unit" => "cm"],
            ["unit_name" => "dozens", "unit" => "dz"],
            ["unit_name" => "feet", "unit" => "ft"],
            ["unit_name" => "gram", "unit" => "g"],
            ["unit_name" => "kilogram", "unit" => "km"],
            ["unit_name" => "pieces", "unit" => "pc"],
        ];
        Unit::insert($data);
    }
}
