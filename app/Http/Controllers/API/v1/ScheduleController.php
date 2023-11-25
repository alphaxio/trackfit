<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\ExerciseProgressContract;
use App\Models\Schedule;
use App\Contracts\ScheduleContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\CreatePEScheduleRequest;
use App\Http\Requests\Schedule\CreatePTScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Http\Resources\v1\ExerciseDayResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\v1\ScheduleResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class ScheduleController extends Controller
{
    use ApiResponses;

    public function __construct(
        private ScheduleContract $scheduleService,
        private ExerciseProgressContract $exerciseProgressService,
    ) {}

    public function createPTSchedule(CreatePTScheduleRequest $request)
    {
        try {
            /** @var User $user */
            $user = auth()->user();
            $attribute = $request->validated();

            $schedule = $this->scheduleService->createPTSchedule($user, $attribute);

            $message = 'Schedule Created Successfully';

            return $this->okayApiResponse([
                'message'               => $message,
                'schedule'              => new ScheduleResource($schedule),
                'regular_exercise_days' => ExerciseDayResource::collection($schedule->exerciseDays),
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }

    public function createPESchedule(CreatePEScheduleRequest $request)
    {
        try {
            /** @var User $user */
            $user = auth()->user();
            $attribute = $request->validated();

            $schedule = $this->scheduleService->createPESchedule($user, $attribute);

            $message = 'Schedule Created Successfully';

            return $this->okayApiResponse([
                'message'               => $message,
                'schedule'              => new ScheduleResource($schedule),
                'regular_exercise_days' => ExerciseDayResource::collection($schedule->exerciseDays),
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }

    private function weekDaysBetween($requiredDays, $start, $end)
    {
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $end);

        $result = [];

        while ($startTime->lt($endTime)) {
            if (in_array($startTime->dayOfWeek, $requiredDays)) {
                array_push($result, $startTime->copy());
            }

            $startTime->addDay();
        }

        return $result;
    }

    public function mySchedules(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $schedules = $this->scheduleService->userSchedules($user);

        if ($schedules->isEmpty()) {
            return $this->errorApiResponse('No Schedules', 404);
        }

        return $this->okayApiResponse([
            'message'     => 'All My Schedules',
            'my_schedule' => ScheduleResource::collection($schedules),
        ]);
    }

    public function activeSchedule(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $active_schedule = $this->scheduleService->userActiveSchedule($user);

        if (is_null($active_schedule)) {
            return $this->errorApiResponse('No Active Schedule', 404);
        }

        return $this->okayApiResponse([
            'message'            => 'My Active Schedules',
            'my_active_schedule' => new ScheduleResource($active_schedule)
        ]);
    }

    public function statSchedule($id): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $schedule = $this->scheduleService->findByUser($id, $user);

        if (is_null($schedule)) {
            return $this->errorApiResponse('Schedule does not exist', 404);
        }

        return $this->okayApiResponse([
            "schedule_statistics" => $this->calculateScheduleStatistics($schedule)
        ]);
    }

    public function activeStatSchedule(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $schedule = $this->scheduleService->userActiveSchedule($user);

        if (is_null($schedule)) {
            return $this->errorApiResponse('No Active Schedule', 404);
        }

        return $this->okayApiResponse([
            "schedule_statistics" => $this->calculateScheduleStatistics($schedule)
        ]);
    }

    private function calculateScheduleStatistics(Schedule $schedule): array
    {
        $statistics = $this->scheduleService->getScheduleStats($schedule);

        if ($schedule->exercise_type == "PT") {
            $total_sessions = $schedule->session_total_count;
            $left = $statistics['miss'] + $statistics['exercised'];
            $_left = $total_sessions - $left - $schedule->session_current_count;

            $statistics["total_sessions"] = $total_sessions;
            $statistics["sessions_left"] = $_left < 0 ? 0 : $_left;
            $statistics["amount_per_session"] = $schedule->amount_per_session;
            $statistics["total_amount"] = $schedule->amount;
            $statistics["exercised"] += $schedule->session_current_count;
        } else {
            $now = Carbon::now();
            $total_months = $schedule->number_of_months;
            $start_date = Carbon::parse($schedule->start_date);
            $end_date = Carbon::parse($start_date)->addMonths($total_months);

            $total_days = $start_date->diffInDays($end_date);
            $_left = $now->diffInDays($end_date, false);

            $statistics["total_months"] = $schedule->number_of_months;
            $statistics["end_date"] = $end_date->format('Y-m-d H:i:s');
            $statistics["days_left"] = $_left;
            $statistics["total_days"] = $total_days;
            $statistics["amount_per_month"] = $schedule->amount_per_month;
            $statistics["exercised"] += $schedule->session_current_count;
            $statistics["total_amount"] = $schedule->amount;
        }

        return $statistics;
    }

    public function updateSchedule(UpdateScheduleRequest $request, $id)
    {
        try {
            $schedule = Schedule::where('id', $id)->where('user_id', auth()->user()->id)->first();

            if (!$schedule) {
                return $this->errorApiResponse('Schedule does not exist', 404);
            }

            $attribute = $request->validated();

            if ($schedule->exercise_type == Schedule::$PT) {
               $schedule = $this->scheduleService->updatePTSchedule($schedule, $attribute);
            } else {
               $schedule = $this->scheduleService->updatePESchedule($schedule, $attribute);
            }

            // TODO: remove this and the column
            //update each schedule
            $exercise_progress = $schedule->exerciseProgress;

            foreach ($exercise_progress as $_exercise) {
                $_exercise->location_name = $attribute['location_name'] ?? $schedule->location_name;
                $_exercise->save();
            }

            $message = 'Schedule Updated Successfully';
            return $this->okayApiResponse([
                'message'  => $message,
                'schedule' => new ScheduleResource($schedule),
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }

    public function endSchedule($id)
    {
        try {
            $schedule = Auth::user()->schedules()->where('id', $id)->first();

            if (!$schedule) {
                return $this->errorApiResponse('Schedule does not exist', 404);
            }

            $schedule->schedule_status = false;
            $schedule->save();

            return $this->successNoDataApiResponse('Schedule ended successfully');
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }
}


