<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AlbumIndexRequest extends FormRequest
{

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['page' => $this->query('page')]);
        $this->merge(['per_page' => $this->query('per_page')]);
        $this->merge(['query' => $this->query('query')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1'],
            'query' => ['nullable', 'string', 'max:255'],
        ];
    }
}
