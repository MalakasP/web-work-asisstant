<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'id'     =>    1,
                'name'   =>   'To Do',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'id'     =>    2,
                'name'   =>   'In Progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'id'     =>    3,
                'name'   =>   'Done',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        );

        DB::table('task_statuses')->insert($data);
    }
}
