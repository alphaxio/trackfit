<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $schedule = $this;
        $lastProgressWithWeight = $schedule->exerciseProgress()->whereNotNull('weight')->latest()->first();

        return [
            'weight' => $this->getWeightStat($schedule, $lastProgressWithWeight),
            'schedule' => new ScheduleResource($schedule),
        ];
    }

    public function getWeightStat($schedule, $lastProgress): array
    {
        $initialWeight = $schedule->weight_before ?? 0;
        $currentWeight = $lastProgress->weight ?? $initialWeight;
        $weightDifference = $currentWeight != 0 ? $currentWeight - $initialWeight : 0;
        $targetWeight = $schedule->target_weight ?? 0;
        $targetLeft = $targetWeight - $currentWeight;

        return [
            'last_updated_date'     => $lastProgress ? $lastProgress->date->format('Y-m-d') : null,
            'initial_weight'        => $initialWeight, // current
            'current_weight'        => $currentWeight, // before
            'weight_difference'     => $weightDifference,
            'target_weight'         => $targetWeight, // target
            'target_weight_left'    => $targetLeft,
        ];
    }
}
