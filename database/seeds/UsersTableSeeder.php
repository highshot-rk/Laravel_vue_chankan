<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * ユーザーのSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 10; $i++) {
            User::create([
                'name'              => '山田太郎'.$i,
                'email'             => 'test'.$i.'@test.com',
                'email_verified_at' => Carbon::now(),
                'password'          => Hash::make('password'),
                'phone'             => '0801111222'.$i,
                'company'           => 'テスト株式会社',
                'prefecture_id'     => 1,
                'manager_id'        => ($i % 2) + 1,
                'limit_login'       => 10,
            ]);
        }
    }
}
