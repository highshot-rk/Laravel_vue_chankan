<?php

use App\Manager;
use Illuminate\Database\Seeder;

/**
 * 管理者のSeeder
 */
class ManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
				Manager::create([
						'name' => 'サンプル',
						'email' => 'xet2b343ud8vf0wd9gnu@cattobi.com',
						'is_active' => true,
						'password' => bcrypt('password'),
						'owner' => 1,
						'reward_rate' => 0.10,
				]);
				Manager::create([
						'name' => 'ZOTMAN運営',
						'email' => '56@zotman.jp',
						'is_active' => true,
						'password' => bcrypt('zotman0550'),
						'owner' => 1,
						'reward_rate' => 0.10,
				]);
    }
}
