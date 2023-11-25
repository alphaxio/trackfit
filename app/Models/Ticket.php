<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::saving(static function ($ticket) {
            if (!$ticket->exists) {
                $ticket->ticket_number = '#' . Carbon::now()->format('Ymd') . '-' . (
                        (Ticket::count() ? Ticket::all()->last()->id : Ticket::count()) + 1000
                    );
            }
        });
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function ticketComment() {
        return $this->hasMany(TicketComment::class);
    }
}
