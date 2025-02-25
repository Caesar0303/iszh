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

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function type()
    {
        return $this->belongsTo(AnimalType::class);
    }

    use HasFactory;
}
