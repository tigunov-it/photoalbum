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
            'query' => ['nullable', 'string', 'max:255'],
        ];
    }
}
