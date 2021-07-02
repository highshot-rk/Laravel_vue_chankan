<?php

use App\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertisement::create([
            'status'     => 0,
            'company'    => 'テスト広告株式会社',
            'url'        => 'https://www.google.co.jp',
            'img_url'    => '/assets/img/258615_s.jpg',
            'tel'        => '0333332221',
            'charge'     => '広告次郎',
            'email'      => 'advertisement1@advertisement.com',
            'phone'      => '09012345673',
            'zip'        => '2220000',
            'manager_id' => 1,
            'address'    => '東京都中野区中野3-3-3 中野ビルディング3F',
        ]);
    }
}
