<?php

namespace Database\Seeders;

use App\Models\Salutation;
use Illuminate\Database\Seeder;

class SalutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Salutation::insert([
            ['salutation' => 'Mr.'],
            ['salutation' => 'Mrs.'],
            ['salutation' => 'Ms.'],
            ['salutation' => 'Miss.'],
            ['salutation' => 'Dr.'],
        ]);
    }
}
