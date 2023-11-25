<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property int $user_id
 * @property int $exercise_type_id
 * @property string|null $exercise_type
 * @property string|null $gender
 * @property string $location_name
 * @property int|null $session_total_count
 * @property int|null $session_current_count
 * @property int|null $number_of_months
 * @property string|null $trainers_name
 * @property int $weight_before
 * @property int|null $target_weight
 * @property int|null $weight_after
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int|null $amount
 * @property int|null $amount_per_session
 * @property int|null $amount_per_month
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $schedule_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExerciseDay> $exerciseDays
 * @property-read int|null $exercise_days_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExerciseProgress> $exerciseProgress
 * @property-read int|null $exercise_progress_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereAmountPerMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereAmountPerSession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereExerciseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereExerciseTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereNumberOfMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereScheduleStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSessionCurrentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSessionTotalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereTargetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereTrainersName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereWeightAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereWeightBefore($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailySchedule> $dailySchedule
 * @property-read int|null $daily_schedule_count
 * @mixin \Eloquent
 */
class Schedule extends Model
{
    use HasFactory;

    public static $MALE = 'MALE';
    public static $FEMALE = 'FEMALE';
    public static $PT = 'PT';
    public static $PE = 'PE';

    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exerciseDays(): HasMany
    {
        return $this->hasMany(ExerciseDay::class);
    }

    public function exerciseProgress()
    {
        return $this->hasMany(ExerciseProgress::class);
    }

    public function dailySchedule(): HasMany
    {
        return $this->hasMany(DailySchedule::class);
    }

    public function progressBodyParts(): HasMany
    {
        return $this->hasMany(ExerciseProgressBodyPart::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('schedule_status', true);
    }
}


