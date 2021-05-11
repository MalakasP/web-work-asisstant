<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\WorktimeService;
use Carbon\Carbon;

class WorktimeServiceTest extends TestCase
{
    /**
     * Clear DB when starting tests
     */
    use RefreshDatabase;


    public function test_calculate_time_returns_zero()
    {
        $firstDate = date(Carbon::now());
        $secondDate = date(Carbon::now());
        $result = WorktimeService::calculateTime($firstDate, $secondDate);
        $this->assertEquals(gmdate("H:i", 0), $result);
    }

    public function test_calculate_time_returns_max_hours()
    {
        $firstDate = date(Carbon::now());
        $secondDate = date(Carbon::now()->addHours(10));
        $result = WorktimeService::calculateTime($firstDate, $secondDate);
        $this->assertEquals(gmdate("H:i", 8*60*60), $result);
    }

    public function test_calculate_time_returns_in_between()
    {
        $firstDate = date(Carbon::now());
        $secondDate = date(Carbon::now()->addHours(5));
        $result = WorktimeService::calculateTime($firstDate, $secondDate);
        $this->assertEquals(gmdate("H:i", 5*60*60), $result);
    }
}
