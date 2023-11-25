<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqQuery extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function faqTopic()
    {
        return $this->belongsTo(FaqTopic::class);
    }
}
