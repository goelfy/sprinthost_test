<?php

namespace App\Http\Controllers;

use App\Models\AnimalSession;
use Illuminate\Http\Request;

class AnimalSessionController extends Controller
{
    /**
     * Создаем сессию для выращивания животных
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $session = new AnimalSession();
        $session->user_agent = $request->userAgent();
        $session->ip = $request->getClientIp();

        abort_if(!$session->save(), 500);

        return [
            'id' => $session->id
        ];
    }
}
