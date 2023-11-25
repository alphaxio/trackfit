<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyStatusResource extends JsonResource
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
            'type' => $this->schedule->pluck('exercise_type')->first(),
            'date' => $this->date->format('Y-m-d'),
            'progress_status' => $this->exerciseProgress->progress_status ?? '',
            'exercise_type' => $this->status,
            'exercise_status' => $this->exerciseProgress->exercise_status ?? '',
            'body_part' => $this->exerciseProgressBodyParts->pluck('body_part'),
        ];
    }
}
