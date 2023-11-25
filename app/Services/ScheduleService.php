<?php

namespace App\Services;

use App\Models\User;
use App\Models\Schedule;
use App\Models\ExerciseProgress;
use App\Contracts\ScheduleContract;
use App\Models\DailySchedule;
use App\Models\ExerciseDay;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Psr\SimpleCache\InvalidArgumentException;

final class ScheduleService implements ScheduleContract
{
    /**
     * @param Schedule $scheduleModel
     */
    public function __construct(
        private Schedule $scheduleModel
    ) {}

    /**
     * @throws InvalidArgumentException
     */
    public function findByUser(int $id, User $user): ?Schedule
    {
        $query = $this->scheduleModel->with(['dailySchedule'])->newQuery();

        $schedule = $query->where("id", $id)->where("user_id", $user->id)->active()->first();

        return $schedule;
    }

    public function userSchedules(User $user): Collection
    {
        return $user->schedules()->orderBy('id', 'desc')->get();
    }

    public function userActiveSchedule(User $user): ?Schedule
    {
        /** @var Schedule $schedule */
        $schedule = $user->schedules()->active()->first();

        return $schedule;
    }

    public function getScheduleStats(Schedule $schedule): array
    {
        $statistics = $schedule->exerciseProgress()->selectRaw('
            COUNT(CASE WHEN exercise_status = ? THEN 1 END) AS miss,
            COUNT(CASE WHEN exercise_status = ? THEN 1 END) AS pass,
            COUNT(CASE WHEN exercise_status = ? THEN 1 END) AS exercised', [
                ExerciseProgress::$MISS,
                ExerciseProgress::$PASS,
                ExerciseProgress::$EXERCISED
            ]
        )->groupBy('schedule_id')->first();

        return $statistics ? $statistics->toArray() : [
            'miss' => 0,
            'pass' => 0,
            'exercised' => 0,
        ];
    }

    public function createPTSchedule($user, $attribute): Schedule
    {
        //save PT schedule
        $schedule = DB::transaction(function () use ($user, $attribute) {

            // End previous active schedule before starting a new one
            $this->endPreviousActiveSchedule($user);
            $date = isset($attribute['start_date']) ? date('Y-m-d H:i:s', strtotime($attribute['start_date'])) : null;

            $schedule = Schedule::newModelInstance();
            $schedule->user_id = $user->id;
            $schedule->exercise_type_id = 2;
            $schedule->exercise_type = Schedule::$PT;
            $schedule->gender = strtoupper($attribute['gender'] ?? null);
            $schedule->start_date = $date;
            $schedule->location_name = $attribute['location_name'];
            $schedule->weight_before = $attribute['weight_before'];
            $schedule->target_weight = $attribute['target_weight'] ?? null;
            $schedule->trainers_name = $attribute['trainers_name'] ?? null;
            $schedule->session_total_count = $attribute['session_total_count'];
            $schedule->amount_per_session = $attribute['amount'] / $attribute['session_total_count'];
            $schedule->schedule_status = 1;
            $schedule->session_current_count = $attribute['session_current_count'] ?? 0;
            $schedule->amount = $attribute['amount'];
            $schedule->save();

            if (isset($attribute['regular_exercise_days'])){
                // Save All exercise day
                $schedule->exerciseDays()->saveMany(array_map(function ($data) {
                    return new ExerciseDay([
                        'day' => $data['day'],
                        'status' => ExerciseDay::$REGULAR,
                    ]);
                }, $attribute['regular_exercise_days']));
            }

            if (isset($attribute['exercise_schedules']))
            {
                foreach($attribute['exercise_schedules'] as $exercised_date)
                {
                    $exercised_date = Carbon::parse($exercised_date['date']);

                    $dailySchedule = DailySchedule::create([
                        'schedule_id' => $schedule->id,
                        'day' => strtoupper($exercised_date->format("l")),
                        'status' => DailySchedule::$IRREGULAR,
                        'type' => null,
                        'week' => 0,
                        'date' => $exercised_date->format('Y-m-d'),
                    ]);

                    $progress = ExerciseProgress::create([
                        'daily_schedule_id' => $dailySchedule->id,
                        'schedule_id' => $schedule->id,
                        'user_id' => Auth::id(),
                        'date' => $exercised_date,
                    ]);
                }
            }

            return $schedule;
        });

        return $schedule;
    }

    public function createPESchedule($user, $attribute): Schedule
    {
        //save PT schedule
        $schedule = DB::transaction(function () use ($user, $attribute) {
            // End previous active schedule before starting a new one
            $this->endPreviousActiveSchedule($user);

            //save PE schedule
            if (array_key_exists('start_date', $attribute) && array_key_exists('number_of_months', $attribute)) {
                $end_date = Carbon::parse(date('Y-m-d H:i:s', strtotime($attribute['start_date'])))->addMonths(
                    intval($attribute['number_of_months'])
                );
            } else {
                $end_date = null;
            }

            if (array_key_exists('amount', $attribute) && array_key_exists('number_of_months', $attribute)) {
                $amount_per_month = intval($attribute['amount']) / intval($attribute['number_of_months']);
            } else {
                $amount_per_month = null;
            }

            $schedule = $user->schedules()->create([
                'exercise_type_id' => 1,
                'exercise_type' => Schedule::$PE,
                'location_name' => $attribute['location_name'],
                'weight_before' => $attribute['weight_before'],
                'target_weight' => $attribute['target_weight'] ?? null,
                'start_date' => isset($attribute['start_date']) ? date('Y-m-d H:i:s', strtotime($attribute['start_date'])) : null,
                'number_of_months' => $attribute['number_of_months'] ?? null,
                'end_date' => $end_date,
                'schedule_status' => 1,
                'amount' => $attribute['amount'] ?? null,
                'amount_per_month' => intval($amount_per_month),
            ]);

            if (isset($attribute['regular_exercise_days'])){
                // Save All exercise day
                $schedule->exerciseDays()->saveMany(array_map(function ($data) {
                    return new ExerciseDay([
                        'day' => $data['day'],
                        'status' => ExerciseDay::$REGULAR,
                    ]);
                }, $attribute['regular_exercise_days']));
            }

            return $schedule;
        });

        return $schedule;
    }

    public function updatePTSchedule($schedule, $attribute): Schedule
    {
        //save PT schedule
        $schedule = DB::transaction(function () use ($schedule, $attribute) {
            $date = isset($attribute['start_date']) ? date('Y-m-d H:i:s', strtotime($attribute['start_date'])) : null;

            $schedule->start_date = $date;
            $session_total_count = $request['session_total_count'] ?? $schedule->session_total_count;
            $session_current_count = $request['session_current_count'] ?? $schedule->session_current_count;
            $amount = $request['amount'] ?? $schedule->amount;
            $amount_per_session = $amount / $session_total_count;

            //save PT schedule
            $schedule->gender = $attribute['gender'] ?? $schedule->gender;
            $schedule->location_name = $attribute['location_name'] ?? $schedule->location_name;
            $schedule->target_weight = $attribute['target_weight'] ?? $schedule->target_weight;
            $schedule->trainers_name = $attribute['trainers_name'] ?? $schedule->trainers_name;
            $schedule->weight_before = $attribute['weight_before'];

            $schedule->session_current_count = $session_current_count;
            $schedule->session_total_count = $session_total_count;
            $schedule->amount_per_session = $amount_per_session;
            $schedule->amount = $amount;
            $schedule->save();

            return $schedule;
        });

        return $schedule;
    }

    public function updatePESchedule($schedule, $attribute): Schedule
    {
        //save PE schedule
        $schedule = DB::transaction(function () use ($schedule, $attribute) {
            $date = isset($attribute['start_date']) ? date('Y-m-d H:i:s', strtotime($attribute['start_date'])) : null;

            $schedule->start_date = $date;
            $number_of_months = $attribute['number_of_months'] ?? $schedule->number_of_months;
            $amount = $attribute['amount'] ?? $schedule->amount;
            $amount_per_month = $amount / $number_of_months;


            //save PE schedule
            if ($number_of_months != $schedule->number_of_months) {
                $end_date = Carbon::parse(date('Y-m-d H:i:s', strtotime($schedule->start_date)))
                            ->addMonths(intval($number_of_months));
            } else {
                $end_date = $schedule->end_date;
            }

            $schedule->location_name = $attribute['location_name'] ?? $schedule->location_name;
            $schedule->weight_before = $attribute['weight_before'];
            $schedule->target_weight = $attribute['target_weight'] ?? $schedule->target_weight;
            $schedule->number_of_months = $number_of_months;
            $schedule->amount = $amount;
            $schedule->end_date = $end_date;
            $schedule->amount_per_month = $amount_per_month;
            $schedule->save();

            return $schedule;
        });

        return $schedule;
    }

    public function updateScheduleRegularDays(Schedule $schedule, $attribute){

        $schedule = DB::transaction(function () use ($schedule, $attribute) {
            if($schedule->exerciseDays){
                $schedule->exerciseDays()->delete();
            }

            if (isset($attribute['regular_exercise_days'])) {
                // Save All exercise day
                $schedule->exerciseDays()->saveMany(array_map(function ($data) {
                    return new ExerciseDay([
                        'day' => $data['day'],
                        'status' => ExerciseDay::$REGULAR,
                    ]);
                }, $attribute['regular_exercise_days']));
            }

            // Save This Week & Next Week
            if ($schedule->exercise_type == Schedule::$PT) {
                if (isset($attribute['exercise_schedules'])) {
                    $dates = collect($attribute['exercise_schedules'])->pluck('date')->all();

                    // remove this week and next week if exist
                    $schedule->dailySchedule()
                        ->whereDate('date', '>=', Carbon::now())
                        ->whereDate('date', '<=', Carbon::now()->endOfWeek()->addDays(7))
                        ->whereNotIn('date', $dates)
                        ->delete();

                    foreach($dates as $date) {
                        $exercised_date = Carbon::parse($date);

                        $dailySchedule = DailySchedule::firstOrCreate(
                        [
                            'schedule_id' => $schedule->id,
                            'date' => $exercised_date->format('Y-m-d'),
                        ],
                        [
                            'day' => strtoupper($exercised_date->format("l")),
                            'status' => DailySchedule::$IRREGULAR,
                            'type' => null,
                            'week' => 0,
                        ]);

                        ExerciseProgress::firstOrCreate(
                            [
                                'schedule_id' => $schedule->id,
                                'date' => $exercised_date->format('Y-m-d'),
                            ],
                            [
                            'daily_schedule_id' => $dailySchedule->id,
                            'user_id' => Auth::id(),
                        ]);
                    }
                }
            }
        });

        return $schedule;
    }

    protected function endPreviousActiveSchedule($user)
    {
        $activeSchedule = $this->userActiveSchedule($user);

        if ($activeSchedule) {
            $activeSchedule->update([
                'schedule_status' => false,
                'end_date' => now(),
            ]);
        }
    }

}
