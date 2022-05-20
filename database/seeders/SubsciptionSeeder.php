<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubsciptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->insert([
            [
                'id' => 1,
                'full_name_owner' => 'Khoa Nguyen',
                'email' => 'khoanguyen8947@gmail.com',
            ],
            [
                'id' => 2,
                'full_name_owner' => 'Employee Andrew',
                'email' => 'khoanguyen89471@gmail.com',
            ]
        ]);
        DB::table('subscription_website')->insert([
            [
                'subscription_id' => 1,
                'website_id' => 1,
            ],
            [
                'subscription_id' => 2,
                'website_id' => 1,
            ],
            [
                'subscription_id' => 1,
                'website_id' => 2,
            ],
            [
                'subscription_id' => 2,
                'website_id' => 2,
            ]
        ]);
    }
}
