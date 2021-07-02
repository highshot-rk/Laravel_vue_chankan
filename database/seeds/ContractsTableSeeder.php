<?php

use App\Contract;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContractsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contract::create([
            'advertisement_id'  => 1,
            'period'            => '1か月',
            'schedule_ended_at' => new Carbon('2020-07-05'),
            'price'             => 3000000,
            'started_at'        =>  new Carbon('2020-06-05'),
            'ended_at'          =>  new Carbon('2020-07-05'),
            'approve_at'        =>  new Carbon('2020-06-05'),
        ]);
        Contract::create([
            'advertisement_id'  => 1,
            'period'            => '3か月',
            'schedule_ended_at' => new Carbon('2020-06-04'),
            'price'             => 3000000,
            'started_at'        =>  new Carbon('2020-03-04'),
            'ended_at'          =>  new Carbon('2020-06-04'),
            'approve_at'        =>  new Carbon('2020-03-04'),
        ]);
    }
}
