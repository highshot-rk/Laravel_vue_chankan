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
            'name' => 'ZOTMAN運営',
            'email' => 'xet2b343ud8vf0wd9gnu@cattobi.com',
            'is_active' => true,
            'password' => bcrypt('password'),
            'owner' => 1,
            'reward_rate' => 0.10,
        ]);
    }
}
