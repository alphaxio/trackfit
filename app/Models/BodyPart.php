<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BodyPart
 *
 * @property int $id
 * @property int $muscle_group_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MuscleGroup $muscleGroup
 * @method static \Illuminate\Database\Eloquent\Builder|BodyPart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BodyPart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BodyPart query()
 * @method static \Illuminate\Database\Eloquent\Builder|BodyPart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodyPart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodyPart whereMuscleGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodyPart whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodyPart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BodyPart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function muscleGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MuscleGroup::class);
    }
}
