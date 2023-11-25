<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ExerciseProgress
 *
 * @property int $id
 * @property int|null $daily_schedule_id
 * @property int|null $schedule_id
 * @property string|null $exercise_status
 * @property string|null $diet_control_status
 * @property int|null $exercise_time_span
 * @property string|null $exercise_time_span_unit
 * @property int|null $weight_loss
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $date
 * @property int|null $exercise_day_id
 * @property string|null $exercise_day
 * @property string|null $progress_status
 * @property int|null $weight
 * @property string|null $exercise_time
 * @property string|null $type
 * @property string|null $location_name
 * @property int|null $user_id
 * @property-read \App\Models\DailySchedule|null $dailySchedule
 * @property-read \App\Models\Schedule|null $schedule
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereDailyScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereDietControlStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereExerciseDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereExerciseDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereExerciseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereExerciseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereExerciseTimeSpan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereExerciseTimeSpanUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereProgressStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseProgress whereWeightLoss($value)
 * @mixin \Eloquent
 */
class ExerciseProgress extends Model
{
    use HasFactory;

    public static $MISS = 'MISS';
    public static $PASS = 'PASS';
    public static $EXERCISED = 'EXERCISED';

    public static $ND = 'ND';
    public static $TD = 'TD';
    public static $EXD = 'EXD';
    public static $MSD = 'MSD';
    public static $NEND = 'NEND';
    public static $NDC = 'NDC';

    public static $NDCE = 'NDCE'; //add to database
    public static $ENDC = 'ENDC';

    public static $PENDC = 'PENDC';
    public static $NDCPE = 'NDCPE';


    //ND = NORMAL DAY
    //TD = TODAY
    //EXD = EXERCISED
    //MSD = MISSED
    //NDC = NO DIET CONTROL
    //NEND = NO EXERCISE, NO DIET CONTROL.
    //NDCE =  EXERCISED, NO DIET CONTROL
    //PENDC = PERSONAL EXERCISE + NO DIET CONTROL


    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
        'note_updated_at' => 'datetime',
    ];

    public function dailySchedule(): BelongsTo
    {
        return $this->belongsTo(DailySchedule::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function exerciseBodyParts(): HasMany
    {
        return $this->hasMany(ExerciseProgressBodyPart::class);
    }

    public function progressImages(): HasMany
    {
        return $this->hasMany(ExerciseProgressImage::class);
    }
}



//ND = NORMAL DAY
//TD = TODAY
//EXD = EXERCISED
//MSD = MISSED
//NDC = NO DIET CONTROL
//NEND = NO EXERCISE, NO DIET CONTROL.
//NDCE =  EXERCISED, NO DIET CONTROL
//NDCPE = PERSONAL EXERCISE + NO DIET CONTROL


//change status codes for e + d;




