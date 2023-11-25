<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public static $PENDING = 'PENDING';
    public static $PAID = 'PAID';
    public static $FAILED = 'FAILED';

    public static array $PAYMENT_STATUS = ['PENDING', 'PAID', 'FAILED'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subscription_id',
        'user_id',
        'transaction_id',
        'amount',
        'status',
        'payment_method',
        'payment_type',
        'payment_response'
    ];

    public function subscription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Subscription::class);
    }
}
