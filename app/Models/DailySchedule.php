<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\DailySchedule
 *
 * @property int $id
 * @property int $schedule_id
 * @property string $day
 * @property string|null $month
 * @property string|null $status
 * @property string|null $type
 * @property int $week
 * @property int|null $year
 * @property \Illuminate\Support\Carbon|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_select
 * @property-read \App\Models\ExerciseProgress|null $exerciseProgress
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereUserSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereYear($value)
 * @mixin \Eloquent
 */
class DailySchedule extends Model
{
    use HasFactory;

    public static $PT = 'PT';
    public static $PE = 'PE';
    public static $MONDAY = 'MONDAY';
    public static $TUESDAY = 'TUESDAY';
    public static $WEDNESDAY = 'WEDNESDAY';
    public static $THURSDAY = 'THURSDAY';
    public static $FRIDAY = 'FRIDAY';
    public static $SATURDAY = 'SATURDAY';
    public static $SUNDAY = 'SUNDAY';

    public static array $DAYS_OF_WEEK = ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'];

    public static $REGULAR = 'REGULAR';
    public static $IRREGULAR = 'IRREGULAR';


    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    public function exerciseProgress(): HasOne
    {
        return $this->hasOne(ExerciseProgress::class);
    }

    public function exerciseProgressBodyParts(): HasMany
    {
        return $this->hasMany(ExerciseProgressBodyPart::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
