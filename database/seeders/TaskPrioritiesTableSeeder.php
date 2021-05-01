<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskPrioritiesTableSeeder extends Seeder
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
                'name'   =>   'Lowest',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'id'     =>    2,
                'name'   =>   'Low',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'id'     =>    3,
                'name'   =>   'Medium',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'id'     =>    4,
                'name'   =>   'High',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'id'     =>    5,
                'name'   =>   'Critical',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        );

        DB::table('task_priorities')->insert($data);
    }
}
