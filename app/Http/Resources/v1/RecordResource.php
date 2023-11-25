<?php

namespace App\Http\Resources\v1;

use App\Models\ExerciseProgress;
use App\Models\ExerciseProgressImage;
use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
        $progress = $this->exerciseProgress;

        return [
            'id' => $this->id,
            'schedule_id' => $this->schedule_id,
            'title' => $this->date->format('Y.m.d') . " ({$this->day})",
            'description' => 'Meal X | Memo O',
            'notes' => $progress->notes ?? null,
            'notes_updated_at' => $progress->note_updated_at ?? null,
            'images' => $this->mapExerciseImage()
        ];
    }

    public function mapExerciseImage(){
        $images = $this->exerciseProgress->progressImages ?? null;
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
