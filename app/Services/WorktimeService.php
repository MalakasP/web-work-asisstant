<?php

namespace App\Services;

use App\Models\Worktime;

class WorktimeService
{
    /**
     * Constant to get hours from seconds or seconds from hours.
     */
    private const HOURS_TO_SECONDS = 3600;

    /**
     * Constant to get hours from minutes or minutes from seconds and vice versa.
     */
    private const HOURS_TO_MIN = 60;



    /**
     * Calculate worktime duration
     * 
     * @param date $created_at
     * @param date $ended_at
     * @return 
     */
    public static function calculateTime($createdAt, $endedAt)
    {
        $createdAt = strtotime($createdAt);
        $endedAt = strtotime($endedAt);

        $hours = floor(abs($createdAt - $endedAt) / WorktimeService::HOURS_TO_SECONDS);
        $minutes = floor(abs($createdAt - $endedAt) / WorktimeService::HOURS_TO_MIN);

        if ($hours >= Worktime::MAX_HOURS) {
            return gmdate("H:i", Worktime::MAX_HOURS * WorktimeService::HOURS_TO_SECONDS);
        } else if ($minutes <= Worktime::MIN_MINUTES) {
            return gmdate("H:i", 0);
        } else {
            $minutes = $minutes - ($minutes % 15);
            return gmdate("H:i", $minutes * WorktimeService::HOURS_TO_MIN);
        }
    }
}
