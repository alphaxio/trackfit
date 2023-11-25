<?php

namespace App\Http\Resources\v1;

use App\Models\DailySchedule;
use App\Models\ExerciseProgress;
use App\Models\Schedule;
use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressStatusResource extends JsonResource
{
    use ApiResources;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->removeNullValues([
            'type' => Schedule::where('id', $this->schedule_id)->pluck('exercise_type')->first(),
            'date' => $this->date->format('Y-m-d'),
            'progress_status' => $this->progress_status,
            'exercise_type' => $this->dailySchedule->status,
        ]);
    }
}
