<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Record\RecordListRequest;
use App\Http\Resources\v1\RecordResource;
use App\Traits\ApiResponses;
use DateTime;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    use ApiResponses;

    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public function getRecordList(RecordListRequest $request){
        try{
            $per_page = $request->per_page ?? 5;
            $dailySchedules = Auth::user()->dailySchedules()
                ->when($request->schedule_ids, function($q) use($request) {
                    $q->whereIn('schedule_id', $request->schedule_ids);
                })
                ->when($request->date, function($q) use($request) {
                    $q->whereDate('date', $request->date);
                })
                ->orderBy('date')
                ->simplePaginate($per_page);

            $records = RecordResource::collection($dailySchedules);
            $message = 'Records Progress & Exercise';

            return $this->paginatedApiResponse($records, $message);
        }catch (\Exception $exception){
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }

    public function showRecord($dailyScheduleId){
        try{
            $dailySchedule = Auth::user()->dailySchedules()->where('daily_schedules.id', $dailyScheduleId)->first();

            if (!$dailySchedule) {
                return $this->errorApiResponse('Data not found', 404);
            }

            $records = new RecordResource($dailySchedule);
            $message = 'Show Records Progress & Exercise';

            return $this->okayApiResponse($records, $message);
        }catch (\Exception $exception){
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }

}
