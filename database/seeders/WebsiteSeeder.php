<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('websites')->insert([
            [
                'id' => 1,
                'domain' => "inisev.com",
                'description' => "Test",
            ],
            [
                'id' => 2,
                'domain' => "khoacv.coworkingnt.com",
                'description' => "Test1",
            ]
        ]);
    }
}
