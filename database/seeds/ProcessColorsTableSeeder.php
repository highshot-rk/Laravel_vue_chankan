<?php

use App\ProcessColor;
use Illuminate\Database\Seeder;

class ProcessColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProcessColor::create([
            'name' => '赤'
        ]);
        ProcessColor::create([
            'name' => 'ピンク'
        ]);
        ProcessColor::create([
            'name' => '群青'
        ]);
        ProcessColor::create([
            'name' => '青'
        ]);
        ProcessColor::create([
            'name' => '薄青'
        ]);
        ProcessColor::create([
            'name' => '水色'
        ]);
        ProcessColor::create([
            'name' => '緑'
        ]);
        ProcessColor::create([
            'name' => '黄緑'
        ]);
        ProcessColor::create([
            'name' => '黄'
        ]);
        ProcessColor::create([
            'name' => 'オレンジ'
        ]);
    }
}
