<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExerciseProgressBodyPart
 *
 * @property int $id
 * @property int|null $body_part_id
 * @property int|null $exercise_progress_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $daily_schedule_id
 * @property string|null $muscle_group
 * @property string|null $body_part
 * @property string|null $date
 * @property int|null $schedule_id
 * @property int|null $muscle_group_id
 * @property string|null $muscle_code
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereBodyPart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereBodyPartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereDailyScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereExerciseProgressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereMuscleCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereMuscleGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereMuscleGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgressBodyPart whereUpdatedAt($value)
 * @property-read \App\Models\BodyPart|null $bodyPart
 * @mixin \Eloquent
 */
class ExerciseProgressBodyPart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bodyPart(): BelongsTo
    {
        return $this->belongsTo(BodyPart::class);
    }
}
