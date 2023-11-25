<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Schedule;
use App\Models\DailySchedule;
use App\Models\ExerciseProgress;
use Illuminate\Http\UploadedFile;
use App\Models\ExerciseProgressImage;
use App\Models\MuscleGroup;
use Illuminate\Database\Eloquent\Collection;

interface ExerciseProgressContract
{
    public function findByDailySchedule(DailySchedule $dailySchedule): ?ExerciseProgress;

    public function create(
        Schedule $schedule,
        DailySchedule $dailySchedule,
        User $user,
        \DateTime $date,
        ?string $status,
        ?string $type = null,
        ?string $dietStatus = null,
        ?string $exerciseTime = null,
        ?int $weight = null,
        ?string $note = null,
    ): ExerciseProgress;

    public function update(
        ExerciseProgress $progress,
        ?string $status = null,
        ?string $type = null,
        ?string $dietStatus = null,
        ?string $exerciseTime = null,
        ?int $weight = null,
        ?string $note = null,
    ): ExerciseProgress;

    public function uploadMedia(
        ExerciseProgress $progress,
        UploadedFile $media,
        string $mediaType
    ): ExerciseProgressImage;

    public function updateBodyParts(ExerciseProgress $progress, ?array $bodyParts = null): ExerciseProgress;

    public function syncProgress(
        ExerciseProgress $progress,
        Schedule $schedule,
        \DateTime $date,
    ): ExerciseProgress;

    public function getMuscleGroupBodyParts(): Collection;

    public function getScheduleProgressList(Schedule $schedule);

    public function getCombinedScheduleProgressList(Schedule $schedule, $exerciseProgress);

    public function checkDailyStatus(Schedule $schedule, $date);

    public function calculateSessionDates($numberOfSessions, $selectedDays, $startDate, $endDate = null);

    public function weekDaysBetween($requiredDays, $start, $end);
}
