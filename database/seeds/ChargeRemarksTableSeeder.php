<?php

use App\ChargeRemark;
use Illuminate\Database\Seeder;

class ChargeRemarksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chargeIds = [1, 2];
        $timeTypes = [
            config('const.project.time_type.am'),
            config('const.project.time_type.pm'),
            config('const.project.time_type.none'),
        ];
        foreach ($chargeIds as $chargeId) {
            foreach ($timeTypes as $timeType) {
                for ($i = 1; $i < 10; $i++) {
                    ChargeRemark::create([
                        'user_id'   => 1,
                        'charge_id' => $chargeId,
                        'work_on'   => '2020-12-0'.$i,
                        'time_type' => $timeType,
                        'remarks'   => '備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考'.$i
                    ]);
                }
            }
        }
    }
}
