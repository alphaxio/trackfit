<?php

namespace App\Helpers;

use App\Models\BodyPart;
use Illuminate\Support\Facades\App;

class CompareBodyHelper
{
    public static function getCompareBodyData(): array
    {
        // Check if the data is already resolved in the container
        if (App::has('compare_body_data')) {
            return App::get('compare_body_data');
        }

        $bodyParts = BodyPart::where('muscle_group_id', 1)->get();
        $compareBodyData = $bodyParts->pluck('name')->toArray();

        // Store the data in the container for future reuse within the same request
        App::instance('compare_body_data', $compareBodyData);

        return $compareBodyData;
    }
}
