<?php

namespace App\Http\Requests;

use App\Models\AnimalSession;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnimalSessionRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'session_id' => [
                'required',
                'numeric',
                Rule::exists(AnimalSession::class, 'id')
            ]
        ];
    }
}
