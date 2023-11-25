<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use App\Models\DailySchedule;
use App\Models\ExerciseProgress;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Models\ExerciseProgressImage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Contracts\ExerciseProgressContract;
use App\Models\BodyPart;
use App\Models\ExerciseProgressBodyPart;
use App\Models\MuscleGroup;
use Exception;
use Illuminate\Database\Eloquent\Collection;

final class ExerciseProgressService implements ExerciseProgressContract
{
    public function findByDailySchedule(DailySchedule $dailySchedule): ?ExerciseProgress
    {
        $progress = $dailySchedule->exerciseProgress;

        return $progress;
    }

    public function calculateProgressStatus($progress){
        switch ($progress->exercise_status) {
            case ExerciseProgress::$EXERCISED:
                $status_check = $progress->diet_control_status == ExerciseProgress::$MISS ?
                    ExerciseProgress::$ENDC :
                    ExerciseProgress::$EXD;
                break;
            case ExerciseProgress::$MISS:
                $status_check = $progress->diet_control_status == ExerciseProgress::$PASS || $progress->diet_control_status == null ?
                    ExerciseProgress::$MSD :
                    ExerciseProgress::$NEND;
                break;
            case ExerciseProgress::$PASS:
                $status_check = ExerciseProgress::$MSD;
                break;
            case null:
                $status_check = null;
                break;
            default:
                if ($progress->diet_control_status == ExerciseProgress::$MISS) {
                    $status_check = ExerciseProgress::$NDC;
                } elseif ($progress->diet_control_status == ExerciseProgress::$PASS) {
                    $status_check = null;
                } else {
                    $status_check = ExerciseProgress::$ND;
                }
                break;
        }

        return $status_check;
    }

    public function syncProgress(
        ExerciseProgress $progress,
        Schedule $schedule,
        \DateTime $date,
    ): ExerciseProgress {
        $status_check = null;

        if (Carbon::now()->format('Y-m-d') == Carbon::parse($date)->format('Y-m-d')) {
            $status_check = ExerciseProgress::$TD;
        } else {
            switch ($progress->exercise_status) {
                case ExerciseProgress::$EXERCISED:
                    $status_check = $progress->diet_control_status == ExerciseProgress::$MISS ?
                        ExerciseProgress::$ENDC :
                        ExerciseProgress::$EXD;
                    break;
                case ExerciseProgress::$MISS:
                    $status_check = $progress->diet_control_status == ExerciseProgress::$PASS || $progress->diet_control_status == null ?
                        ExerciseProgress::$MSD :
                        ExerciseProgress::$NEND;
                    break;
                case ExerciseProgress::$PASS:
                    $status_check = ExerciseProgress::$MSD;
                    break;
                default:
                    if ($progress->diet_control_status == ExerciseProgress::$MISS) {
                        $status_check = ExerciseProgress::$NDC;
                    } elseif ($progress->diet_control_status == ExerciseProgress::$PASS) {
                        $status_check = null;
                    } else {
                        $status_check = ExerciseProgress::$ND;
                    }
                    break;
            }
        }


        $progress->progress_status = $status_check;
        $progress->type = $schedule->exercise_type;
        $progress->save();

        return $progress;
    }

    public function getMuscleGroupBodyParts(): Collection
    {
        $cacheKey = "getMuscleGroupBodyParts";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $muscle_groups = MuscleGroup::with('bodyPart')->get();

        Cache::set($cacheKey, $muscle_groups, now()->addDay());

        return $muscle_groups;
    }

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
    ): ExerciseProgress {
        /** @var ExerciseProgress $progress */
        $progress = $dailySchedule->exerciseProgress()->newModelInstance();

        if ($status == 'RESET') {
            $progress->exercise_status = NULL;
        }else{
            $progress->exercise_status = $status;
        }

        if ($dietStatus == 'RESET') {
            $progress->diet_control_status = NULL;
        }else{
            $progress->diet_control_status = $dietStatus;
        }

        if($type != null){
            $progress->type = $type;
        }else{
            $progress->type = $schedule->exercise_type;
        }

        $progress->daily_schedule_id = $dailySchedule->id;
        $progress->schedule_id = $schedule->id;
        $progress->user_id = $user->id;
        $progress->date = $date;
        $progress->location_name = $schedule->location_name;
        $progress->exercise_time = $exerciseTime;
        $progress->weight = $weight;
        $progress->note = $note;
        $progress->note_updated_at = Carbon::now();
        $progress->progress_status = $this->calculateProgressStatus($progress);
        $progress->save();

        return $progress;
    }

    public function update(
        ExerciseProgress $progress,
        ?string $status = null,
        ?string $type = null,
        ?string $dietStatus = null,
        ?string $exerciseTime = null,
        ?int $weight = null,
        ?string $note = null,
    ): ExerciseProgress {
        if($status == null){
            $progress->exercise_status = $progress->exercise_status;
        }else{
            if ($status == 'RESET') {
                $progress->exercise_status = NULL;
            }else{
                $progress->exercise_status = $status;
            }
        }

        if($dietStatus == null){
            $progress->diet_control_status = $progress->diet_control_status;
        }else{
            if ($dietStatus == 'RESET') {
                $progress->diet_control_status = NULL;
            }else{
                $progress->diet_control_status = $dietStatus;
            }
        }

        if($type != null){
            $progress->type = $type;
        }

        $progress->exercise_time = $exerciseTime ?? $progress->exercise_time;
        $progress->weight = $weight ?? $progress->weight;
        if($note != $progress->note){
            $progress->note_updated_at = Carbon::now();
        }
        $progress->note = $note ?? $progress->note;
        $progress->progress_status = $this->calculateProgressStatus($progress);
        $progress->save();

        return $progress;
    }

    public function uploadMedia(
        ExerciseProgress $progress,
        UploadedFile $media,
        string $mediaType
    ): ExerciseProgressImage {
        return DB::transaction(function () use ($progress, $media, $mediaType) {
            $progress->progressImages()->where('image_type', $mediaType)->delete();

            $path = Storage::disk('s3')->put('images', $media);

            return $progress->progressImages()->create([
                'daily_schedule_id' => $progress->daily_schedule_id,
                'image_url'         => Storage::disk('s3')->url($path),
                'schedule_id'       => $progress->schedule_id,
                'progress_date'     => $progress->date,
                'user_id'           => $progress->user_id,
                'location_name'     => $progress->location_name,
                'image_type'        => $mediaType
            ]);
        });
    }

    public function updateBodyParts(
        ExerciseProgress $progress,
        ?array $bodyParts = null
    ): ExerciseProgress {
        $check_body_part = $progress->exerciseBodyParts;

        foreach ($check_body_part as $_body_part) {
            $_body_part->delete();
        }

        if (!empty($bodyParts)) {
            if (!in_array(0, $bodyParts)) {
                foreach ($bodyParts as $body_part_id) {
                    $check_body_part = ExerciseProgressBodyPart::query()->where(
                        'exercise_progress_id',
                        $progress->id
                    )->where('body_part_id', $body_part_id)->exists();
                    if (!$check_body_part) {
                        $bodypart = BodyPart::where('id', $body_part_id)->first();
                        $progress_body_part = new  ExerciseProgressBodyPart();
                        $progress_body_part->exercise_progress_id = $progress->id;
                        $progress_body_part->daily_schedule_id = $progress->daily_schedule_id;
                        $progress_body_part->schedule_id = $progress->schedule_id;
                        $progress_body_part->body_part_id = $body_part_id;
                        $progress_body_part->body_part = $bodypart->name;
                        $progress_body_part->muscle_group = $bodypart->muscleGroup->name;
                        $progress_body_part->muscle_code = $bodypart->muscleGroup->muscle_code;
                        $progress_body_part->muscle_group_id = $bodypart->muscleGroup->id;
                        $progress_body_part->date = Carbon::parse($progress->date);
                        $progress_body_part->save();
                    }
                }
            }
        }

        return $progress;
    }

    public function getScheduleProgressList(Schedule $schedule){
        // Fetch Exercise Progress From Schedule
        $progress = $schedule->exerciseProgress()
                    ->with([
                        'dailySchedule',
                        'schedule',
                        'schedule.progressBodyParts',
                        'exerciseBodyParts',
                        'progressImages',
                    ])
                    ->orderBy('date')
                    ->get();

        return $progress;
    }


    public function getCombinedScheduleProgressList(Schedule $schedule, $exerciseProgress){
        $combined_data = [];
        $dates = [];
        $selected_days = $schedule->exerciseDays->pluck('day')->toArray();
        $start_date = Carbon::parse($schedule->start_date);

        // get all dates from existing first
        foreach($exerciseProgress as $progress) {
            $combined_data[] = $progress;
        }

        if($schedule->exercise_type === Schedule::$PT){
            $total_session = $schedule->session_total_count;
            $dates = $this->calculateSessionDates($total_session, $selected_days, $start_date);
        }else if($schedule->exercise_type === Schedule::$PE){
            $total_months = $schedule->number_of_months;
            $end_date = Carbon::parse($start_date)->addMonths($total_months);
            $dates = $this->weekDaysBetween($selected_days, $start_date, $end_date);
        }


        foreach($dates as $date){
            $searchDate = $date;
            $searchedObject = array_filter($combined_data, function ($item) use ($searchDate) {
                return $item["date"] === $searchDate;
            });

            if (empty($searchedObject)) {
                $combined_data[] = [
                    'schedule_id' => $schedule->id,
                    'date' => $date,
                    'exercise_type' => DailySchedule::$REGULAR,
                ];
            }
        }

        // Add Weekly Body Part
        // foreach($combined_data as $key => $data){
        //     if(isset($data['weekly_body_part'])){
        //         $start_of_week = Carbon::parse($data['date'])->startOfWeek();
        //         $end_of_week = Carbon::parse($data['date'])->endOfWeek();

        //         // Loop through each date within the week
        //         $currentDate = $start_of_week;
        //         while ($currentDate <= $end_of_week) {
        //             $searchDate = $currentDate->format('Y-m-d');
        //             $searchedKey = null;

        //             // Search for an existing entry for the current date
        //             foreach ($combined_data as $entryKey => $entry) {
        //                 if ($entry['date'] === $searchDate) {
        //                     $searchedKey = $entryKey;
        //                     break;
        //                 }
        //             }

        //             // If a matching date is found, update the 'weekly_body_part'
        //             if ($searchedKey !== null) {
        //                 $combined_data[$searchedKey]['weekly_body_part'] = $data['weekly_body_part'];
        //                 // Add other updates to existing properties as needed
        //             } else {
        //                 // If no entry is found, add a new entry for that date
        //                 if($currentDate->gte($schedule->start_date)){
        //                     $combined_data[] = [
        //                         'schedule_id' => $data['schedule_id'],
        //                         'date' => $searchDate,
        //                         'exercise_type' => null,
        //                         'weekly_body_part' => $data['weekly_body_part'],
        //                         // Include other properties from $data that you need for the new entry
        //                     ];
        //                 }

        //             }

        //             // Move to the next date
        //             $currentDate->addDay();
        //         }
        //     }
        // }



        // Define the comparison function for sorting based on "date" field
        $compareByDate = function ($item1, $item2) {
            return strtotime($item1['date']) <=> strtotime($item2['date']);
        };

        // Sort the $combined_data array using the defined comparison function
        usort($combined_data, $compareByDate);

        return $combined_data;
    }

    function calculateSessionDates($numberOfSessions, $selectedDays, $startDate, $endDate = null)
    {
        $validDays = DailySchedule::$DAYS_OF_WEEK;
        $selectedDays = array_intersect($selectedDays, $validDays);

        $selectedDays = array_map('strtoupper', $selectedDays);

        // Initialize an array to store the session dates
        $sessionDates = [];

        // Stop counting if no selectedDays
        if(count($selectedDays) < 1) {
            return $sessionDates;
        }

        // Loop through the days until we have the desired number of sessions
        while (count($sessionDates)  < $numberOfSessions) {
            // Check if the current day of the week is in the selectedDays array
            if (in_array(strtoupper($startDate->englishDayOfWeek), $selectedDays)) {
                // Add the session date to the array
                $sessionDates[] = $startDate->toDateString();
            }

            // Move to the next day
            $startDate->addDay();

            // Check if we have reached the end date
            if ($endDate && $startDate->gt($endDate)) {
                break;
            }
        }

        // If we end up with more session dates than required, trim the extra dates
        if (count($sessionDates) > $numberOfSessions) {
            $sessionDates = array_slice($sessionDates, 0, $numberOfSessions);
        }

        return $sessionDates;
    }

    public function weekDaysBetween($requiredDays, $start, $end)
    {
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $end);

        $result = [];

        // Stop counting if no selectedDays
        if(count($requiredDays) < 1) {
            return $result;
        }

        while ($startTime->lt($endTime)) {
            if (in_array(strtoupper($startTime->englishDayOfWeek), $requiredDays)) {
                array_push($result, $startTime->copy()->toDateString());
            }

            $startTime->addDay();
        }

        return $result;
    }

    public function checkDailyStatus(Schedule $schedule, $date)
    {
        $status = '';

        $date = $date->toDateString();
        $selected_days = $schedule->exerciseDays->pluck('day')->toArray();
        $start_date = Carbon::parse($schedule->start_date);

        if($schedule->exercise_type === Schedule::$PT){
            $total_session = $schedule->session_total_count;
            $dates = $this->calculateSessionDates($total_session, $selected_days, $start_date);
        }else if($schedule->exercise_type === Schedule::$PE){
            $total_months = $schedule->number_of_months;
            $end_date = Carbon::parse($start_date)->addMonths($total_months);
            $dates = $this->weekDaysBetween($selected_days, $start_date, $end_date);
        }


        if(in_array($date, $dates)){
            $status = DailySchedule::$REGULAR;
        }else{
            $status = DailySchedule::$IRREGULAR;
        }

        return $status;
    }
}
