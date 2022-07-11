<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_session_id',
        'animal_kind_id',
        'age'
    ];

    public function kind()
    {
        return $this->belongsTo(AnimalKind::class, 'animal_kind_id', 'id');
    }

    public function size() : Attribute
    {
        return Attribute::make(
            get: function(){
                $size = $this->kind->growth_factor * $this->age;
                return $size > $this->kind->max_size ? $this->kind->max_size : $size;
            },
        );
    }
}
