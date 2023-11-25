<?php

namespace App\Rules;

use App\Models\DailySchedule;
use Illuminate\Contracts\Validation\Rule;

final class DayOfWeekRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return in_array(strtoupper($value), DailySchedule::$DAYS_OF_WEEK);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid Day Of The Week.';
    }
}
