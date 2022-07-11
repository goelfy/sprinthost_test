<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalKind extends Model
{
    use HasFactory;

    protected $casts = [
        'growth_factor' => 'double'
    ];

    public function getImgUrlAttribute($value)
    {
        return asset($this->img);
    }

    protected function img(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset($value),
        );
    }
}
