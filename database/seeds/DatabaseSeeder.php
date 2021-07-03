<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            // ChargesTableSeeder::class,
            // ProjectsTableSeeder::class,
            // ProjectLabelsTableSeeder::class,
            // ProjectOrderersTableSeeder::class,
            PrefecturesTableSeeder::class,
            ManagersTableSeeder::class,
            // AdvertisementsTableSeeder::class,
            // ContractsTableSeeder::class,
            // ChargeRemarksTableSeeder::class,
            ProcessColorsTableSeeder::class,
        ]);
    }
}
