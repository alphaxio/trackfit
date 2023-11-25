<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MuscleGroup
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $muscle_code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BodyPart> $bodyPart
 * @property-read int|null $body_part_count
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup whereMuscleCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MuscleGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MuscleGroup extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bodyPart(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BodyPart::class);
    }
}
