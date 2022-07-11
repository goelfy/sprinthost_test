<?php

namespace App\Http\Controllers;

use App\Models\AnimalKind;

class AnimalKindController extends Controller
{
    /**
     * Получаем все доступные типы животных
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function all()
    {
        return AnimalKind::get(['id', 'name', 'max_age', 'max_size', 'growth_factor', 'img']);
    }
}
