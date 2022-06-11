<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Calendar extends Model
{
    use HasFactory, HasApiTokens;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'date',
        'duration',
        'start_time',
        'end_time'
    ];

}
