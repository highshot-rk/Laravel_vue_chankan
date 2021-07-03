<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            Project::create([
                'label'              => $i,
                'user_id'            => 1,
                'project_orderer_id' => ($i % 10) + 1,
                'name'               => 'テスト建設案件' . $i,
                'charge_id'          => 1,
                'work_on'            => '2020-12-0'.$i%10,
                'zip'                => '1110000',
                'address'            => '東京都足立区足立2-2-2 足立ビルディング2F',
                'tel'                => '09000001111',
                'project_type'       => 0,
                'time_type'          => ($i % 3),
                'road'               => 0,
                'remark'             => '注意事項注意事項注意事項注意事項注意事項注意事項注意事項注意事項注意事項',
                'last_messaged_at'   => null,
                'is_notified'        => 0,
                'notified_at'        => null,
                'is_surveyed'        => 0,
                'surveyed_at'        => null,
                'is_started'         => 0,
                'started_at'         => null,
                'is_finished'        => 0,
                'finished_at'        => null,
                'finish_img'         => null,
                'url'                => null,
            ]);
            Project::create([
                'label'              => $i,
                'user_id'            => 1,
                'project_orderer_id' => ($i % 10) + 1,
                'name'               => 'テスト建設案件' . $i,
                'charge_id'          => 1,
                'work_on'            => ($i % 3) == 1 ? null : '2020-07-05',
                'zip'                => '1110000',
                'address'            => '東京都足立区足立2-2-2 足立ビルディング2F',
                'tel'                => '09000001111',
                'project_type'       => ($i % 3) == 1 ? 1 : 2,
                'time_type'          => ($i % 3),
                'road'               => 0,
                'remark'             => '注意事項注意事項注意事項注意事項注意事項注意事項注意事項注意事項注意事項',
                'last_messaged_at'   => null,
                'is_notified'        => 0,
                'notified_at'        => null,
                'is_surveyed'        => 0,
                'surveyed_at'        => null,
                'is_started'         => 0,
                'started_at'         => null,
                'is_finished'        => 0,
                'finished_at'        => null,
                'finish_img'         => null,
                'url'                => null,
            ]);
        }
    }
}
