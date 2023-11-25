<?php

namespace App\Http\Resources\v1;

use App\Helpers\CompareBodyHelper;
use App\Models\DailySchedule;
use App\Models\ExerciseProgressImage;
use App\Traits\ApiResources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressResource extends JsonResource
{
    use ApiResources;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $weeklyBodyPart = $this->getBodyPartThisWeek();
        $compareBody = array_diff(CompareBodyHelper::getCompareBodyData(), $weeklyBodyPart->pluck('name')->toArray());

        $partNotExMessage = '';
        if (count($compareBody) <= 2) {
            $partNotExMessage = '이번 주에 ' . implode(", ", $compareBody) . ' 운동 안했어요';
        }

        return [
            'id'                      => $this->id,
            'user_id'                 => $this->user_id,
            'schedule_id'             => $this->schedule_id,
            'exercise_schedule_id'    => $this->daily_schedule_id,
            'date'                    => $this->date->format('Y-m-d'),
            'progress_status'         => $this->progress_status,
            'diet_control_status'     => $this->diet_control_status,
            'exercise_type'           => $this->getExcerciseStatus(),
            'is_additional_date'      => $this->dailySchedule->is_additional_date ? true : false,
            'type'                    => $this->type,
            'exercise_status'         => $this->exercise_status,
            'exercise_time'           => $this->exercise_time,
            'exercise_day'            => $this->exercise_day,
            'notes'                   => $this->note,
            'notes_updated_at'        => $this->note_updated_at != null ? $this->note_updated_at->format('Y-m-d H:i:s') : null,
            'schedule'                => new ProgresScheduleResource($this->schedule),
            'exercise_schedule'       => new DailyScheduleResource($this->dailySchedule),
            'weight'                  => $this->getWeightStat(),
            'weekly_body_part'        => ExerciseBodyPartResource::collection($weeklyBodyPart),
            'selected_body_part'      => ExerciseBodyPartResource::collection($this->exerciseBodyParts),
            'part_not_ex_message'     => $partNotExMessage,
            'images'                  => $this->mapExerciseImage(),
        ];
    }

    public function getExcerciseStatus(){
        $exercise_days = $this->schedule->exerciseDays->pluck('day')->toArray();

        $status = $this->dailySchedule->status ?? '';

        if($status === DailySchedule::$REGULAR){
            if(!in_array($this->dailySchedule->day, $exercise_days) && $this->exercise_status === null && $this->dailySchedule->is_additional_date){
                return DailySchedule::$IRREGULAR;
            }
        }

        return $status;
    }

    public function getBodyPartThisWeek()
    {
        $dayOfWeek = $this->date;

        $startOfWeek = Carbon::parse($dayOfWeek)->startOfWeek();
        $endOfWeek = Carbon::parse($dayOfWeek)->endOfWeek();

        // Eager load the progressBodyParts relationships for the entire week
        $this->schedule->load([
            'progressBodyParts' => function ($query) use ($startOfWeek, $endOfWeek) {
                $query->whereDate('date', '>=', $startOfWeek->toDateString())
                    ->whereDate('date', '<=', $endOfWeek->toDateString());
            },
        ]);

        // Access the eager-loaded relationship directly
        $weeklyBodyPart = $this->schedule->progressBodyParts;

        // Use the unique method to filter the collection based on the "body_part_id" column
        $uniqueWeeklyBodyPart = $weeklyBodyPart->unique('body_part_id');

        return $uniqueWeeklyBodyPart;
    }

    public function getWeightStat(): array
    {
        $currentWeight = $this->weight ?? 0;
        $initialWeight = $this->schedule->weight_before ?? 0;
        $weightDifference = $currentWeight - $initialWeight;

        return [
            'initial_weight'    => $initialWeight,
            'current_weight'    => $currentWeight,
            'weight_difference' => $weightDifference,
        ];
    }

    public function mapExerciseImage(){
        $images = $this->progressImages ?? null;
        $images = $images ? ExerciseProgressImageResource::collection($images) : null;

        if($images){
            $mappedImages = $images->mapWithKeys(function($image){
                return [
                    $image->image_type => $image->image_url,
                ];
            });

            // Merge the mapped images with the default array
            return $this->getDefaultImageArray()->merge($mappedImages);
        }

        // Return the default array if $images is null or empty
        return $this->getDefaultImageArray();
    }

    private function getDefaultImageArray()
    {
        return collect([
            ExerciseProgressImage::$BODY => '',
            ExerciseProgressImage::$BREAKFAST => '',
            ExerciseProgressImage::$LUNCH => '',
            ExerciseProgressImage::$DINNER => '',
            ExerciseProgressImage::$OTHER => '',
        ]);
    }
}
