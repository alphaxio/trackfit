<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }


}
