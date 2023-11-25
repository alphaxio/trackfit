<?php

namespace App\Contracts;

use App\Models\Schedule;
use App\Models\ExerciseDay;
use Illuminate\Database\Eloquent\Collection;

interface ExerciseDayContract
{
    public function findByScheduleAndDay(Schedule $schedule, string $day): ?ExerciseDay;

    public function getBySchedule(Schedule $schedule): Collection;

    public function deleteMultipleByDays(Schedule $schedule, array $days): bool;
}
