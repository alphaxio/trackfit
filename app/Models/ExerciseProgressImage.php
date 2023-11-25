<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExerciseProgressImage
 *
 * @property int $id
 * @property int|null $exercise_progress_id
 * @property string|null $image_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $image_type
 * @property int|null $daily_schedule_id
 * @property int|null $schedule_id
 * @property string|null $progress_date
 * @property string|null $location_name
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereDailyScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereExerciseProgressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereImageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereProgressDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressImage whereUserId($value)
 * @mixin \Eloquent
 */
class ExerciseProgressImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $BREAKFAST = 'BREAKFAST';
    public static $LUNCH = 'LUNCH';
    public static $DINNER = 'DINNER';
    public static $BODY = 'BODY';
    public static $OTHER = 'OTHER';
}
