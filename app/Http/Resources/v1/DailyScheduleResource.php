<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyScheduleResource extends JsonResource
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
            'schedule_id' => $this->schedule_id,
            'day' => $this->day,
            'month' => $this->month,
            'type' => $this->type,
            'week' => $this->week,
            'year' => $this->year,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'status' => $this->status,
        ];
    }
}
