<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\ScheduleContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\v1\ExerciseTypeResource;
use App\Http\Resources\v1\ScheduleResource;
use App\Models\ExerciseProgress;
use App\Models\ExerciseType;
use App\Models\Schedule;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExerciseController extends Controller
{
    use ApiResponses;

    public function __construct(private ScheduleContract $scheduleService) {}

    public function types()
    {
        try {
            $exercises = ExerciseType::all();
            if ($exercises->count() == 0) {
                return $this->errorApiResponse('No exercise type found', 404);
            }
            $exercises_data = new ExerciseTypeResource($exercises);
            $message = 'List of exercise schedule';
            return $this->okayApiResponse([
                'message'       => $message,
                'exercise_type' => $exercises_data,
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }
}
