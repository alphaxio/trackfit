<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExerciseType
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExerciseType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
