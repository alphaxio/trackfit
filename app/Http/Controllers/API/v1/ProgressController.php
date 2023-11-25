<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\ScheduleContract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\ExerciseDayContract;
use App\Contracts\DailyScheduleContract;
use App\Http\Resources\v1\BodyPartResource;
use App\Contracts\ExerciseProgressContract;
use App\Http\Requests\Progress\UploadMediaRequest;
use App\Http\Requests\Progress\UpdateProgressRequest;
use App\Http\Resources\v1\MuscleGroupBodyPartsResource;
use App\Http\Resources\v1\MuscleGroupResource;
use App\Http\Resources\v1\ProgressResource;
use App\Models\BodyPart;
use App\Models\DailySchedule;
use App\Models\ExerciseDay;
use App\Models\ExerciseProgress;
use App\Models\ExerciseProgressImage;
use App\Models\MuscleGroup;
use App\Models\Schedule;
use App\Traits\ApiResponses;
use Carbon\Carbon;
use DateTime;
use Exception;

class ProgressController extends Controller
{
    use ApiResponses;

    public function __construct(
        private ScheduleContract $scheduleService,
        private DailyScheduleContract $dailyScheduleService,
        private ExerciseDayContract $exerciseDayService,
        private ExerciseProgressContract $exerciseProgressService,
    ) {}

    private function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public function getAllScheduleProgress()
    {
        // Get Active Schedule
        $schedule = Auth::user()->schedules()->active()->first();

        if(!$schedule) {
            return $this->okayApiResponse([
                'message'    => "No Data Exercise Schedule & Progress",
                'progress'   => [],
            ]);
        }

        $progress = $this->exerciseProgressService->getScheduleProgressList($schedule);
        $availableProgress = ProgressResource::collection($progress)->toArray(request());
        $data = $this->exerciseProgressService->getCombinedScheduleProgressList($schedule, $availableProgress);

        return $this->okayApiResponse([
            'message'    => "All Exercise Schedule & Progress",
            'progress'   => $data,
        ]);
    }


    // This function use to create new progress or update existing progress
    public function updateProgress(int $id, string $date, UpdateProgressRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $schedule = $this->scheduleService->findByUser($id, $user);

        if (is_null($schedule)) {
            return $this->errorApiResponse('Schedule not found or not active', 404);
        }

        $check_date = $this->validateDate($date);

        if (!$check_date) {
            return $this->errorApiResponse('Wrong date format, use (Y-m-d)', 400);
        }

        $date = Carbon::createFromFormat('Y-m-d', $date);
        $dailySchedule = $this->dailyScheduleService->getBySchedule($schedule, $date);

        if (is_null($dailySchedule)) {
            $type = $this->exerciseProgressService->checkDailyStatus($schedule, $date);

            $dailySchedule = $this->dailyScheduleService->create(
                $schedule,
                $date,
                $type,
            );
        }

        if ($request->has('exercise_type')) {
            $dailySchedule = $this->dailyScheduleService->updateStatus(
                $dailySchedule,
                empty($request->input('exercise_type')) ? null : $request->input('exercise_type')
            );
        }

        $progress = $dailySchedule->exerciseProgress;

        if (is_null($progress)) {
            $progress = $this->exerciseProgressService->create(
                $schedule,
                $dailySchedule,
                $user,
                $date,
                $request->input('exercise_status'),
                $request->input('type'),
                $request->input('diet_control_status'),
                $request->input('exercise_time'),
                $request->input('weight'),
                $request->input('notes'),
            );
        } else {
            $progress = $this->exerciseProgressService->update(
                $progress,
                $request->input('exercise_status'),
                $request->input('type'),
                $request->input('diet_control_status'),
                $request->input('exercise_time'),
                $request->input('weight'),
                $request->input('notes'),
            );
        }

        if($request->has('body_part_ids')){
            $this->exerciseProgressService->updateBodyParts($progress, $request->input('body_part_ids'));
        }

        // Refetch data and relations
        $dailySchedule = $dailySchedule->refresh();
        $progress = optional($dailySchedule->exerciseProgress)->refresh();

        $progress->with([
            'dailySchedule',
            'schedule',
            'schedule.progressBodyParts',
            'exerciseBodyParts',
            'progressImages']
        )->first();


        return $this->okayApiResponse([
            'message'    => "Exercise Schedule & Progress",
            'progress'   =>  new ProgressResource($progress),
        ]);
    }

    public function uploadMedia(int $id, string $date, UploadMediaRequest $request)
    {
        $user = Auth::user();
        $schedule = $this->scheduleService->findByUser($id, $user);

        if (is_null($schedule)) {
            return $this->errorApiResponse('Schedule not found', 404);
        }

        $check_date = $this->validateDate($date);

        if (!$check_date) {
            return $this->errorApiResponse('Wrong date format, use (Y-m-d)', 400);
        }

        $mediaTypeAliases = [
            'body_image'      => ExerciseProgressImage::$BODY,
            'dinner_image'    => ExerciseProgressImage::$DINNER,
            'lunch_image'     => ExerciseProgressImage::$LUNCH,
            'breakfast_image' => ExerciseProgressImage::$BREAKFAST,
        ];

        $date = Carbon::createFromFormat('Y-m-d', $date);
        $dailySchedule = $this->dailyScheduleService->getBySchedule($schedule, $date);

        if (is_null($dailySchedule)) {
            $dailySchedule = $this->dailyScheduleService->create(
                $schedule,
                $date,
            );
        }

        if ($request->has('exercise_type')) {
            $dailySchedule = $this->dailyScheduleService->updateStatus(
                $dailySchedule,
                empty($request->input('exercise_type')) ? null : $request->input('exercise_type')
            );
        }

        $progress = $this->exerciseProgressService->findByDailySchedule($dailySchedule);

        if (is_null($progress)) {
            $progress = $this->exerciseProgressService->create(
                $schedule,
                $dailySchedule,
                $user,
                $date,
                $request->input('exercise_status'),
                $request->input('diet_control_status'),
                $request->input('exercise_time'),
                $request->input('weight'),
                $request->input('note'),
            );
        }

        foreach ($request->validated() as $imageType => $image) {
            if (array_key_exists($imageType, $mediaTypeAliases) === false) {
                continue;
            }

            $this->exerciseProgressService->uploadMedia($progress, $image, $mediaTypeAliases[$imageType]);
        }

        return $this->okayApiResponse([
            'message'    => "Exercise Schedule & Progress",
            'progress'   =>  new ProgressResource($progress),
        ]);
    }


    private function statScehdule($id)
    {
        try {
            $schedule = Schedule::where('user_id', auth()->user()->id)->where("id", $id)->first();

            if (!$schedule) {
                return $this->errorApiResponse('No Active Schedule', 404);
            }

            if ($schedule->exercise_type == "PT") {
                $total_sessions = $schedule->session_total_count;

                $miss = ExerciseProgress::where('schedule_id', $schedule->id)->where(
                    'exercise_status',
                    ExerciseProgress::$MISS
                )->count();
                $pass = ExerciseProgress::where('schedule_id', $schedule->id)->where(
                    'exercise_status',
                    ExerciseProgress::$PASS
                )->count();
                $exercised = ExerciseProgress::where('schedule_id', $schedule->id)->where(
                    'exercise_status',
                    ExerciseProgress::$EXERCISED
                )->count();
                $left = $miss + $exercised;
                $_left = $total_sessions - $left;
                $statistics = [
                    "total"              => $total_sessions,
                    "miss"               => $miss,
                    "pass"               => $pass,
                    "exercised"          => $exercised,
                    "sessions_left"      => $_left,
                    "amount_per_session" => $schedule->amount_per_session,
                    "total_amount"       => $schedule->amount
                ];
            } else {
                $miss = ExerciseProgress::where('schedule_id', $schedule->id)->where(
                    'exercise_status',
                    ExerciseProgress::$MISS
                )->count();
                $exercised = ExerciseProgress::where('schedule_id', $schedule->id)->where(
                    'exercise_status',
                    ExerciseProgress::$EXERCISED
                )->count();
                $now = Carbon::now();
                $end_date = $schedule->end_date ?? 0;
                $_left = $now->diffInDays($end_date, false);
                $statistics = [
                    "total_months" => $schedule->number_of_months,
                    "end_date"     => $end_date,
                    "miss"         => $miss,
                    "exercised"    => $exercised,
                    "days_left"    => $_left,
                ];
            }
            return $statistics;
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }

    public function getExerciseDays($id)
    {
        try {
            //check if user is the owner of that schedule
            $schedule = Schedule::where('id', $id)->where('user_id', auth()->user()->id)->first();
            if (!$schedule) {
                return $this->errorApiResponse('You do not own this schedule', 404);
            }
            $exercise_days = ExerciseDay::where('schedule_id', $id)->get();

            if ($exercise_days->count() == 0) {
                return $this->errorApiResponse('No Exercise Days Registered For This Schedule', 404);
            }
            $message = 'Exercise Days Fetched Successfully';
            return $this->okayApiResponse([
                'message'  => $message,
                'schedule' => $exercise_days,
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }

    public function getBodyParts()
    {
        try {
            $body_parts = BodyPart::get();
            if (!$body_parts) {
                return $this->errorApiResponse('There are no body parts found', 404);
            }
            $message = 'Body Parts Fetched Successfully';
            return $this->okayApiResponse([
                'message'    => $message,
                'body_parts' => BodyPartResource::collection($body_parts),
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }


    public function getMuscleGroups()
    {
        try {
            $muscle_groups = MuscleGroup::get();
            if (!$muscle_groups) {
                return $this->errorApiResponse('There are no muscle groups found', 404);
            }
            $message = 'Muscle Group Fetched Successfully';
            return $this->okayApiResponse([
                'message'       => $message,
                'muscle_groups' => MuscleGroupResource::collection($muscle_groups),
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }


    public function getMuscleGroupsBodyPart($id)
    {
        try {
            $body_parts = BodyPart::where('muscle_group_id', $id)->get();
            if (!$body_parts) {
                return $this->errorApiResponse('There are no body parts found', 404);
            }
            $message = 'Body Parts Fetched Successfully';
            return $this->okayApiResponse([
                'message'    => $message,
                'body_parts' => BodyPartResource::collection($body_parts),
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }

    public function muscleGroupBodyParts()
    {
        try {
            $muscle_groups = $this->exerciseProgressService->getMuscleGroupBodyParts();

            if (!$muscle_groups) {
                return $this->errorApiResponse('There are no muscle groups found', 404);
            }
            $message = 'Muscle Group And Body Fetched Successfully';
            return $this->okayApiResponse([
                'message'                 => $message,
                'muscle_group_body_parts' => MuscleGroupBodyPartsResource::collection($muscle_groups),
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }

    // private function buildCommonResponse(
    //     ExerciseProgress $progress,
    //     Schedule $schedule,
    //     DailySchedule $dailySchedule,
    //     \DateTime $date
    // ): \Illuminate\Http\JsonResponse {
    //     //big muscles
    //     $bm_body_part = $this->progressBodyService->getBodyPartsByProgress($progress);
    //     $bm_d_body_part = $this->progressBodyService->getBodyPartsByProgress($progress, Carbon::now());

    //     $bm__week_body_part = $this->progressBodyService->getProgressBodyByWeek($schedule, Carbon::parse($date), 1);

    //     $bm_check_body = array_unique($bm__week_body_part);
    //     $bm_compare_body = [];

    //     foreach ($bm_check_body as $bm_c_body) {
    //         $bm_compare_body[] = $bm_c_body;
    //     }

    //     $bm_compare_body = array_diff($bm_compare_body, $bm_check_body);

    //     $week_body_part = $this->progressBodyService->getProgressBodyByWeek($schedule, Carbon::parse($date));

    //     $check_body = array_unique($week_body_part);
    //     $compare_body = BodyPart::where('muscle_group_id', 1)->pluck('name')->toArray();

    //     $compare_body = array_diff($compare_body, $check_body);

    //     $weight = $this->exerciseProgressService->getWeightStat($schedule, Carbon::parse($date));

    //     $progress = $this->exerciseProgressService->syncProgress($progress, $schedule, Carbon::parse($date));

    //     $now = Carbon::now();
    //     $all_progresses = DailySchedule::where('schedule_id', $schedule->id)
    //         ->whereBetween("date", [(clone $now)->subDays(10), (clone $now)->addDays(10)])
    //         ->orderBy('date', 'ASC')
    //         ->get();

    //     $images = $this->exerciseProgressService->getProgressImages($progress);

    //     return $this->okayApiResponse([
    //         'message'                 => 'exercise schedule and progress',
    //         'schedule'                => new ProgresScheduleResource($schedule),
    //         'exercise_schedule'       => new DailyScheduleResource($dailySchedule),
    //         'progress'                => new ExerciseProgressResource ($progress),
    //         'weight'                  => $weight,
    //         //big muscles
    //         'today_body_part'         => $bm_d_body_part,
    //         'previous_date_body_part' => $bm_body_part,
    //         'weekly_body_part'        => array_values(array_unique($bm__week_body_part)),
    //         'part_not_exercised'      => array_values($bm_compare_body),
    //         'part_not_ex_message'     => Carbon::now() == Carbon::now()->endOfWeek() || count(
    //             $compare_body
    //         ) <= 2 ? '이번 주에 ' . implode(" , ", array_values($compare_body)) . ' 운동 안했어요' : '',
    //         'body_image'              => ProgressImageResource::collection($images['body_image']),
    //         'breakfast_image'         => ProgressImageResource::collection($images['breakfast_image']),
    //         'lunch_image'             => ProgressImageResource::collection($images['lunch_image']),
    //         'dinner_image'            => ProgressImageResource::collection($images['dinner_image']),
    //         'statistics'              => $this->statScehdule($schedule->id),
    //         'status'                  => DailyStatusResource::collection($all_progresses),
    //     ]);
    // }
}
