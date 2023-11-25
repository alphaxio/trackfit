<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseProgressResource extends JsonResource
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
        return [
            'id' => $this->id,
            'exercise_schedule_id' => $this->daily_schedule_id,
            'schedule_id' => $this->schedule_id,
            'exercise_status' => $this->exercise_status,
            'diet_control_status' => $this->diet_control_status,
            'running_time' => $this->exercise_time,
            'weight' => $this->weight,
            'note' => $this->note,
            'note_updated_at' => $this->note_updated_at,
            'date' => $this->date,
            'exercise_day' => $this->exercise_day,
            'progress_status' => $this->progress_status,
        ];
    }
}
