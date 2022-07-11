<?php

namespace App\Service;

use App\Models\Animal;

/**
 * Сервис для Animal
 */
class AnimalService
{

    /**
     * Получить всех животных за сессию
     * @param $session_id
     * @return mixed
     */
    public static function getAllFromSession($session_id)
    {
        return Animal::where('animal_session_id', $session_id)->get();
    }

    /**
     * Рост животных в сессии
     * @param int $session_id
     * @return int
     */
    public static function ageInSession(int $session_id): int
    {
        $animals = Animal::where('animal_session_id', $session_id)
            ->with('kind')
            ->get();

        $animals = $animals->filter(function ($animal) {
            return $animal->age < $animal->kind->max_age;
        });

        return Animal::whereIn('id', $animals->pluck('id'))
            ->increment('age');
    }
}
