<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ReportResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use ApiResponses;


    public function getReportList($schedule_id) {
        $schedule = Auth::user()->schedules()->where('id', $schedule_id)->first();

        if(is_null($schedule)){
            return $this->errorApiResponse("Schedule Not Found", 404);
        }

        $data = new ReportResource($schedule);

        $message = "Success Retrieve Data";
        return $this->successApiResponse($message, $data, 200);
    }
}
