<?php

namespace App\Http\Requests;

use App\Models\AnimalKind;
use App\Models\AnimalSession;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnimalCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'session_id' => [
                'required',
                'numeric',
                Rule::exists(AnimalSession::class, 'id')
            ],
            'animal_kind_id' => [
                'required',
                'numeric',
                Rule::exists(AnimalKind::class, 'id')
            ],
        ];
    }
}
