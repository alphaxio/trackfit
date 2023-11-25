<?php

namespace App\Http\Resources\v1;

use App\Models\ExerciseProgress;
use App\Models\ExerciseProgressBodyPart;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ApiResources;

class CalenderResource extends JsonResource
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
        $bodyParts = ExerciseProgressBodyPart::where('daily_schedule_id', $this->id)
            ->select('muscle_code', 'body_part')
            ->get()
            ->groupBy('muscle_code')
            ->map->pluck('body_part');

        return [
            'id' => $this->id,
            'schedule_id' => $this->schedule_id,
            'day' => $this->day,
            'month' => $this->month,
            'type' => $this->type,
            'year' => $this->year,
            'date' => $this->date ? $this->date->format('Y-m-d') : $this->date,
            'status' => $this->status,
            'progress' => new ExerciseProgressResource($this->exerciseProgress),
            'body_parts' => $bodyParts->isEmpty() ? null : $bodyParts,
        ];
    }
}
