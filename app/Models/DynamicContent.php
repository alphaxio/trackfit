<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicContent extends Model
{
    use HasFactory;

    public static $FAQ = 'FAQ';
    public static $TERMS = 'TERMS';
    public static $POLICY = 'POLICY';
    public static $CONTACT = 'CONTACT';


    protected $guarded = ['id'];




}
