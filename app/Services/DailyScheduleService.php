<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\DailySchedule;
use Illuminate\Support\Facades\DB;
use App\Contracts\ExerciseDayContract;
use App\Models\ExerciseProgress;
use Psr\SimpleCache\InvalidArgumentException;

final class DailyScheduleService implements \App\Contracts\DailyScheduleContract
{
    public function __construct(
        private ExerciseDayContract $exerciseDayService
    ) {}

    /**
     * @param Schedule $schedule
     * @param \DateTime $date
     * @return DailySchedule|null
     * @throws InvalidArgumentException
     */
    public function getBySchedule(Schedule $schedule, \DateTime $date): ?DailySchedule
    {
        /** @var ?DailySchedule $dailySchedule */
        $dailySchedule = $schedule->dailySchedule()->with(['exerciseProgress'])->whereDate("date", $date)->first();

        return $dailySchedule;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(
        Schedule $schedule,
        \DateTime $date,
        ?string $type = null,
    ): DailySchedule {
        /** @var DailySchedule $dailySchedule */
        $dailySchedule = $schedule->dailySchedule()->newModelInstance();

        $service = new ExerciseProgressService();

        $dailySchedule->schedule_id = $schedule->id;
        $dailySchedule->day = strtoupper($date->format("l"));
        $dailySchedule->status = $type;
        $dailySchedule->type = null;
        $dailySchedule->week = 0;
        $dailySchedule->date = $date->format('Y-m-d');
        $dailySchedule->is_additional_date = $service->checkDailyStatus($schedule, $date) != DailySchedule::$REGULAR;
        $dailySchedule->save();

        return $dailySchedule;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function updateStatus(DailySchedule $dailySchedule, ?string $status): DailySchedule
    {
        $dailySchedule->status = $status;
        $dailySchedule->save();

        return $dailySchedule;
    }

    public function deleteMultiple(Schedule $schedule, array $day): bool
    {
        //TODO Remove Cache
        return DB::transaction(function () use ($schedule, $day) {
            $schedule->dailySchedule()->whereIn('day', $day)->where(
                'date',
                '>',
                Carbon::now()
            )->delete();

            $this->exerciseDayService->deleteMultipleByDays($schedule, $day);

            return true;
        });
    }
}
