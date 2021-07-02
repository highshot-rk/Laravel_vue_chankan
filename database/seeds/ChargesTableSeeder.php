<?php

use App\Charge;
use Illuminate\Database\Seeder;

/**
 * 担当者情報のSeeder
 */
class ChargesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Charge::create([
            'user_id' => 1,
            'phone' => '08011112222',
            'email' => 'testcharge1@aaa.com',
            'name' => '田中たつや',
            'edit_type' => 1,
            'password' => bcrypt('password'),
            // 'sort' => 1,
        ]);
        Charge::create([
            'user_id' => 1,
            'phone' => '08011112222',
            'email' => 'testcharge2@aaa.com',
            'name' => '清水よしこ',
            'edit_type' => 0,
            'password' => bcrypt('password'),
            // 'sort' => 2,
        ]);
        Charge::create([
            'user_id' => 1,
            'phone' => '08011112222',
            'email' => 'testcharge3@aaa.com',
            'name' => '山田三郎',
            'edit_type' => 0,
            'password' => bcrypt('password'),
            // 'sort' => 3,
        ]);
        Charge::create([
            'user_id' => 1,
            'phone' => '08011112222',
            'email' => 'testcharge4@aaa.com',
            'name' => '山田史郎',
            'edit_type' => 0,
            'password' => bcrypt('password'),
            // 'sort' => 4,
        ]);
    }
}
