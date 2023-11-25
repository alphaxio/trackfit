<?php

namespace App\Contracts;

use App\Models\Schedule;
use App\Models\DailySchedule;

interface DailyScheduleContract
{
    public function getBySchedule(Schedule $schedule, \DateTime $date): ?DailySchedule;

    public function create(
        Schedule $schedule,
        \DateTime $date,
        ?string $type = null,
    ): DailySchedule;

    public function updateStatus(DailySchedule $dailySchedule, ?string $status): DailySchedule;

    public function deleteMultiple(Schedule $schedule, array $day): bool;
}
