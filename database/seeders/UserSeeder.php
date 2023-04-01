<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            'email_verified_at' => '2023-02-14 12:16:26',
            'password' => Hash::make('user'),
            'is_business_admin' => '1',
            'is_blocked' => '0',
        ]);
        Business::insert([
            'user_id' => '1',
            'country_id' => '231',
            'state_id' => '3396',
            'business' => 'Try lo tech',
        ]);
        Tax::insert([
            'business_id' => '1',
            'name' => 'gst',
            'rate' => '10',
        ]);
    }
}
