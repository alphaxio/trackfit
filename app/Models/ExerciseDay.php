<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExerciseDay
 *
 * @property int $id
 * @property int $schedule_id
 * @property string $day
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseDay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExerciseDay extends Model
{
    use HasFactory;

    public static $REGULAR = 'REGULAR';
    public static $IRREGULAR = 'IRREGULAR';

    public static $MONDAY = 'MONDAY';
    public static $TUESDAY = 'TUESDAY';
    public static $WEDNESDAY = 'WEDNESDAY';
    public static $THURSDAY = 'THURSDAY';
    public static $FRIDAY = 'FRIDAY';
    public static $SATURDAY = 'SATURDAY';
    public static $SUNDAY = 'SUNDAY';

    protected $guarded = ['id'];
}
