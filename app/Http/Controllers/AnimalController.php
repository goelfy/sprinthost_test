<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalCreateRequest;
use App\Http\Requests\AnimalSessionRequest;
use App\Models\Animal;
use App\Service\AnimalService;

class AnimalController extends Controller
{


    /**
     * Все животные по сессии
     * @param AnimalSessionRequest $request
     * @return mixed
     */
    public function all(AnimalSessionRequest $request)
    {
        $post = $request->validated();

        return AnimalService::getAllFromSession($post['session_id'])
            ->only(['id', 'animal_kind_id', 'size', 'age']);
    }

    /**
     * Создаем животное выбранного типа и подкрепляем к сессии
     * @param AnimalCreateRequest $request
     * @return mixed
     */
    public function create(AnimalCreateRequest $request)
    {
        $post = $request->validated();

        $animal = Animal::create([
            'animal_session_id' => $post['session_id'],
            'animal_kind_id' => $post['animal_kind_id'],
            'age' => 1
        ]);

        return $animal->only(['id', 'animal_kind_id', 'size', 'age']);

    }

    /**
     * Увеличиваем возраст животных в сессии
     * @param AnimalSessionRequest $request
     * @return mixed
     */
    public function age(AnimalSessionRequest $request)
    {
        $post = $request->validated();

        AnimalService::ageInSession($post['session_id']);

        return AnimalService::getAllFromSession($post['session_id'])->map(function ($row){
           return $row->only('id', 'animal_kind_id', 'age', 'size');
        });
    }
}
