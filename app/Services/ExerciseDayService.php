<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\ExerciseDay;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Psr\SimpleCache\InvalidArgumentException;

final class ExerciseDayService implements \App\Contracts\ExerciseDayContract
{
    /**
     * @throws InvalidArgumentException
     */
    public function findByScheduleAndDay(Schedule $schedule, string $day): ?ExerciseDay
    {
        $day = strtoupper($day);

        /** @var ?ExerciseDay $exerciseDay */
        $exerciseDay = $schedule->exerciseDays()->where("day", $day)->first();

        return $exerciseDay;
    }

    public function getBySchedule(Schedule $schedule): Collection
    {
        return $schedule->exerciseDays;
    }

    public function deleteMultipleByDays(Schedule $schedule, array $days): bool
    {
        $schedule->exerciseDays()->whereIn('day', $days)->delete();

        return true;
    }
}
