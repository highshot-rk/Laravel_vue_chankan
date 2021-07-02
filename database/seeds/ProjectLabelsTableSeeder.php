<?php

use App\ProjectLabel;
use Illuminate\Database\Seeder;

class ProjectLabelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            ProjectLabel::create([]);
        }
    }
}
