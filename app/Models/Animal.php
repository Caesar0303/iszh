<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'owner_id',
        'region',
        'city',
        'type',
        'breed',
        'image',
        'gender',
        'date_of_birth',
        'direction',
        'reason_for_staging',
        'date_for_registration',
        'identification_method',
        'note',
        'price'
    ];

    use HasFactory;
}
