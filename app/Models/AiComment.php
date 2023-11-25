<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AiComment
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $type
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AiComment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AiComment extends Model
{
    use HasFactory;
}
