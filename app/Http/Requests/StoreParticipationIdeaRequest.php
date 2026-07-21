<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreParticipationIdeaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'response_preference' => ['required', 'string', Rule::in(['public', 'private'])],
            'name' => [
                'nullable',
                'string',
                'max:120',
                Rule::requiredIf(fn (): bool => $this->input('response_preference') === 'public'),
                Rule::prohibitedIf(fn (): bool => $this->input('response_preference') === 'private'),
            ],
            'email' => [
                'nullable',
                'email:rfc',
                'max:255',
                Rule::requiredIf(fn (): bool => $this->input('response_preference') === 'public'),
                Rule::prohibitedIf(fn (): bool => $this->input('response_preference') === 'private'),
            ],
            'club_or_role' => ['nullable', 'string', 'max:140'],
            'topic' => ['required', 'string', 'in:clubes,arbitraje,formacion,competicion,comunicacion,otro'],
            'idea' => ['required', 'string', 'min:40', 'max:3000'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }
}
