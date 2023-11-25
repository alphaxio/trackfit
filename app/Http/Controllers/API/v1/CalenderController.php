<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Illuminate\Support\Arr;
use App\Contracts\ScheduleContract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\ExerciseDayContract;
use App\Contracts\DailyScheduleContract;
use App\Http\Resources\v1\CalenderByWeekResource;
use App\Http\Resources\v1\CalenderResource;
use App\Http\Resources\v1\ExerciseDayResource;
use App\Models\DailySchedule;
use App\Models\ExerciseDay;
use App\Models\ExerciseProgress;
use App\Models\Schedule;
use App\Traits\ApiResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Calendar\AddRegularDaysRequest;
use App\Http\Requests\Calendar\UpdateRegularDaysRequest;
use App\Services\ExerciseProgressService;

class CalenderController extends Controller
{
    use ApiResponses;

    public function __construct(
        private ScheduleContract $scheduleService,
        private DailyScheduleContract $dailyScheduleContract,
        private ExerciseDayContract $exerciseDayService,
        private ExerciseProgressService $exerciseProgressService,
    ) {}

    private function weekDaysBetween($requiredDays, $start, $end): array
    {
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $end);

        $result = [];

        while ($startTime->lt($endTime)) {
            if (in_array($startTime->dayOfWeek, $requiredDays)) {
                $result[] = $startTime->copy();
            }

            $startTime->addDay();
        }

        return $result;
    }

    public function regularDays($id): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $schedule = $this->scheduleService->findByUser($id, $user);

        if (is_null($schedule)) {
            return $this->errorApiResponse('Schedule not found', 404);
        }

        $calenderSchedules = $this->exerciseDayService->getBySchedule($schedule);

        if ($calenderSchedules->isEmpty()) {
            return $this->errorApiResponse('No Regular Days', 404);
        }

        return $this->okayApiResponse([
            'message'               => 'Your schedule regular days',
            'regular_exercise_days' => ExerciseDayResource::collection($calenderSchedules),
        ]);
    }

    public function updateRegularDaysSchedule(UpdateRegularDaysRequest $request, int $scheduleId): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $schedule = $this->scheduleService->findByUser($scheduleId, $user);
        $attribute = $request->validated();

        if (is_null($schedule)) {
            return $this->errorApiResponse('Schedule not found', 404);
        }

        $this->scheduleService->updateScheduleRegularDays($schedule, $attribute);

        if ($schedule->exercise_type == Schedule::$PT) {
            $message = 'Days and Schedule Updated Successfully';
        } else {
            $message = 'Days Updated Successfully';
        }

        return $this->successNoDataApiResponse($message);
    }

    // public function updateRegularDaysSchedule(UpdateRegularDaysRequest $request, int $schedule): \Illuminate\Http\JsonResponse
    // {
    //     $user = Auth::user();
    //     $_schedule = $this->scheduleService->findByUser($schedule, $user);

    //     if (is_null($_schedule)) {
    //         return $this->errorApiResponse('Schedule not found', 404);
    //     }

    //     $attribute = $request->validated();

    //     $regular_days = array_unique(
    //         Arr::pluck($attribute['regular_exercise_days'], 'day')
    //     );

    //     $_regular_days = $_schedule->exerciseDays;

    //     $official_days = [];
    //     $unofficial_days = [];

    //     foreach ($_regular_days as $reg) {
    //         $tempDay = strtolower($reg->day);

    //         if (in_array($tempDay, $regular_days)) {
    //             $official_days[] = $reg->day;
    //         } else {
    //             $unofficial_days[] = $reg->day;
    //         }
    //     }

    //     //remove
    //     if (!empty($unofficial_days)) {
    //         $this->dailyScheduleContract->deleteMultiple($_schedule, $unofficial_days);
    //     }

    //     foreach ($_regular_days as $reg) {
    //         if (($key = array_search(strtolower($reg->day), $regular_days)) !== false) {
    //             unset($regular_days[$key]);
    //         }
    //     }
    //     //add
    //     if (count($regular_days) > 0) {
    //         foreach ($regular_days as $key => $day) {
    //             $exercise_day = new ExerciseDay();
    //             $exercise_day->schedule_id = $_schedule->id;
    //             $exercise_day->day = $day;
    //             $exercise_day->status = ExerciseDay::$REGULAR;
    //             $exercise_day->save();
    //         }

    //         $start_date = $_schedule->start_date ? Carbon::parse($_schedule->start_date) : Carbon::now();
    //         $end_int = $_schedule->session_total_count ?? 12;
    //         $end_date = Carbon::parse(date('Y-m-d H:i:s', strtotime($start_date)))->addMonths(intval($end_int));
    //         // $end_date = Carbon::parse(date('Y-m-d H:i:s H:i:s', strtotime($start_date)))->addMonths(intval($_schedule->session_total_count));
    //         $days = [];

    //         foreach ($regular_days as $day) {
    //             $days[] = array_search(strtoupper($day), DailySchedule::$DAYS_OF_WEEK);
    //         }

    //         $dates = $this->weekDaysBetween($days, $start_date, $end_date);

    //         foreach ($dates as $date) {
    //             DailySchedule::where('schedule_id', $schedule)->where('status', DailySchedule::$IRREGULAR)->where(
    //                 'date',
    //                 $date->format('Y-m-d H:i:s')
    //             )->where('date', '>', Carbon::now())->delete();
    //         }
    //         foreach ($dates as $date) {
    //             $daily_schedule = new DailySchedule();
    //             $daily_schedule->schedule_id = $_schedule->id;
    //             $daily_schedule->day = strtoupper(Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('l'));
    //             $daily_schedule->status = DailySchedule::$REGULAR;
    //             $daily_schedule->type = null;
    //             $daily_schedule->week = 0;
    //             $daily_schedule->date = date('Y-m-d H:i:s', strtotime($date));
    //             $daily_schedule->save();
    //             //save progress
    //             $progress = new ExerciseProgress();
    //             $progress->daily_schedule_id = $daily_schedule->id;
    //             $progress->schedule_id = $_schedule->id;
    //             $progress->date = $date;
    //             $progress->save();
    //         }
    //     }


    //     /////////////////////////////////////////////////////////
    //     $exercise_days = ExerciseDay::where('schedule_id', $schedule)->get();

    //     if (array_key_exists('exercise_schedules', $attribute)) {
    //         foreach ($attribute['exercise_schedules'] as $key => $irregular) {
    //             foreach ($exercise_days as $_day_schedules) {
    //                 if (strtoupper($irregular['day']) === strtoupper($_day_schedules->day)) {
    //                     return $this->errorApiResponse(
    //                         'You already have ' . $_day_schedules['day'] . ' as an official day',
    //                         400
    //                     );
    //                 }
    //             }
    //         }
    //     }

    //     if (array_key_exists('exercise_schedules', $attribute)) {
    //         $_deleteSchedule = DailySchedule::query()->where('status', DailySchedule::$IRREGULAR)->where(
    //             'schedule_id',
    //             $schedule
    //         )->where('date', '>', Carbon::now())->get();
    //         foreach ($_deleteSchedule as $key => $_delete) {
    //             $_delete->delete();
    //         }
    //     }

    //     if ($_schedule->exercise_type == Schedule::$PT) {
    //         if (array_key_exists('exercise_schedules', $attribute)) {
    //             foreach ($attribute['exercise_schedules'] as $key => $data) {
    //                 $_checkSchedule = DailySchedule::query()->where('date', $data['date'])->where(
    //                     'schedule_id',
    //                     $schedule
    //                 )->exists();
    //                 if (!$_checkSchedule == true) {
    //                     $daily_schedule = new DailySchedule();
    //                     $daily_schedule->schedule_id = $schedule;
    //                     $daily_schedule->day = $data['day'];
    //                     $daily_schedule->status = ExerciseDay::query()->where(
    //                         'day',
    //                         strtoupper($data['day'])
    //                     )->exists() ? DailySchedule::$REGULAR : DailySchedule::$IRREGULAR;
    //                     $daily_schedule->type = $data['type'] ?? null;
    //                     $daily_schedule->week = $data['week'] ?? 0;
    //                     $daily_schedule->date = date('Y-m-d H:i:s', strtotime($data['date']));
    //                     $daily_schedule->save();
    //                 }
    //             }
    //         }
    //     }
    //     // $daily_schedule = DailySchedule::where('schedule_id', $schedule)->orderByDesc('date', 'asc')->get();
    //     $daily_schedule = DailySchedule::where('schedule_id', $schedule)->orderBy('date', 'ASC')->get();
    //     $regular_days = ExerciseDay::where('schedule_id', $schedule)->get();
    //     if ($_schedule->exercise_type == Schedule::$PT) {
    //         $message = 'Days and Schedule Updated Successfully';
    //     } else {
    //         $message = 'Days Updated Successfully';
    //     }

    //     return $this->successNoDataApiResponse($message);
    // }

    public function calenderSchedule($schedule): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $active_schedule = Schedule::where('user_id', $user->id)->where('id', $schedule)->first();

        if (is_null($active_schedule)) {
            return $this->errorApiResponse('Schedule does not exist', 404);
        }

        $thisMonthRange = [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ];
        $thisWeekRange = [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ];
        $nextWeekRange = [
            Carbon::now()->startOfWeek()->addDays(7),
            Carbon::now()->endOfWeek()->addDays(7)
        ];

        $daily_schedule = DailySchedule::where('schedule_id', $active_schedule->id)
            ->whereBetween('date', $thisMonthRange)
            ->orderBy('date', 'ASC')
            ->get();

        $this_week = DailySchedule::where('schedule_id', $active_schedule->id)
            ->whereBetween('date', $thisWeekRange)
            ->orderBy('date', 'ASC')
            ->get();

        $next_week = DailySchedule::where('schedule_id', $active_schedule->id)
            ->whereBetween('date', $nextWeekRange)
            ->orderBy('date', 'ASC')
            ->get();

        $calender_schedules = ExerciseDay::where('schedule_id', $active_schedule->id)->get();

        if ($calender_schedules->isEmpty()) {
            return $this->errorApiResponse('No Regular Days', 404);
        }

        return $this->okayApiResponse([
            'message'               => 'Calender Schedule Fetched Successfully',
            'schedule_type'         => $active_schedule->exercise_type,
            'regular_exercise_days' => ExerciseDayResource::collection($calender_schedules),
            'this_week'             => CalenderByWeekResource::collection($this_week),
            'next_week'             => CalenderByWeekResource::collection($next_week),
            'calender_schedule'     => CalenderResource::collection($daily_schedule) ?? 'Not Available',

        ]);
    }

    public function activeCalender(Request $request)
    {
        $this->validate($request, [
            'month' => 'required',
            'year' => 'required',
        ]);

        $schedule = Auth::user()->schedules()->active()->first();

        if (!$schedule) {
            return $this->errorApiResponse('You do not have an active schedule', 404);
        }

        $dates = [];
        $data = [];
        $selected_days = $schedule->exerciseDays->pluck('day')->toArray();
        $exercise_days = $schedule->exerciseDays;

        $date = Carbon::createFromFormat('Y-m-d', $request->year."-".$request->month."-01");
        $start_date = $date->copy()->startOfMonth();
        $end_date = $date->copy()->endOfMonth();


        $daily_schedule = with(clone $schedule)->dailySchedule()
            ->whereDate('date', '>=', $date->copy()->startOfMonth())
            ->whereDate('date', '<=', $date->copy()->endOfMonth())
            ->orderBy('date', 'ASC')
            ->get();

        $availableDailySchedules = CalenderResource::collection($daily_schedule)->toArray(request());

        // get all dates from existing first
        foreach($availableDailySchedules as $progress) {
            $data[] = $progress;
        }

        if($schedule->exercise_type === Schedule::$PT){
            $total_session = $schedule->session_total_count;
            $dates = $this->exerciseProgressService->calculateSessionDates($total_session, $selected_days, $start_date, $end_date);
        }else if($schedule->exercise_type === Schedule::$PE){
            $total_months = $schedule->number_of_months;
            $end_date = Carbon::parse($start_date)->addMonths($total_months);
            $dates = $this->exerciseProgressService->weekDaysBetween($selected_days, $start_date, $end_date);
        }

        foreach($dates as $date){
            $searchDate = $date;
            $searchedObject = array_filter($data, function ($item) use ($searchDate) {
                return $item["date"] === $searchDate;
            });
            $date = Carbon::parse($date);

            if (empty($searchedObject)) {
                $data[] = [
                    'schedule_id' => $schedule->id,
                    'day' => strtoupper($date->format('l')),
                    'month' => $date->format('F'),
                    'type' => $schedule->exercise_type,
                    'year' => $date->format('Y'),
                    'date' => $date->format('Y-m-d'),
                    'status' => DailySchedule::$REGULAR,
                    'progress' => null,
                    'body_parts' => null,
                ];
            }
        }

        // Define the comparison function for sorting based on "date" field
        $compareByDate = function ($item1, $item2) {
            return strtotime($item1['date']) <=> strtotime($item2['date']);
        };

        // Sort the $data array using the defined comparison function
        usort($data, $compareByDate);

        $collection = collect($data);

        $thisWeekRange = [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ];

        $nextWeekRange = [
            Carbon::now()->startOfWeek()->addDays(7),
            Carbon::now()->endOfWeek()->addDays(7)
        ];

        $thisWeek = $collection->filter(function ($item) use ($thisWeekRange) {
            $itemDate = Carbon::parse($item['date']);
            return $itemDate->between($thisWeekRange[0], $thisWeekRange[1]);
        })->map(function ($item) {
            return [
                "day" => $item["day"],
                "type" => $item["type"],
                "date" => $item["date"],
                "status" => $item["status"]
            ];
        })->values();

        $nextWeek = $collection->filter(function ($item) use ($nextWeekRange) {
            $itemDate = Carbon::parse($item['date']);
            return $itemDate->between($nextWeekRange[0], $nextWeekRange[1]);
        })->map(function ($item) {
            return [
                "day" => $item["day"],
                "type" => $item["type"],
                "date" => $item["date"],
                "status" => $item["status"]
            ];
        })->values();

        return $this->okayApiResponse([
            'message'               => 'Calender Schedule Fetched Successfully',
            'schedule_type'         => $schedule->exercise_type,
            'regular_exercise_days' => ExerciseDayResource::collection($exercise_days),
            'this_week'             => $thisWeek,
            'next_week'             => $nextWeek,
            'calender_schedule'     => $data,
        ]);
    }
}
