<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleContract
{
    public function findByUser(int $id, User $user): ?Schedule;

    public function userSchedules(User $user): Collection;

    public function userActiveSchedule(User $user): ?Schedule;

    //TODO: Change Return Type To DTO
    public function getScheduleStats(Schedule $schedule): array;

    public function createPTSchedule($user, $request): Schedule;

    public function createPESchedule($user, $request): Schedule;

    public function updatePTSchedule($schedule, $request): Schedule;

    public function updatePESchedule($schedule, $request): Schedule;

    public function updateScheduleRegularDays(Schedule $schedule, $attributes);
}
