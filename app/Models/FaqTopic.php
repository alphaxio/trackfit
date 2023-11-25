<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqTopic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function faqQuery()
    {
        return $this->hasMany(FaqQuery::class);
    }
}
