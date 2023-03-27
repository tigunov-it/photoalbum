<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OAT;

#[OAT\RequestBody(
    request: 'PostUpdateRequest',
    content: new OAT\JsonContent(properties: [
        new OAT\Property(property: 'title', type: 'string', maxLength: 255),
        new OAT\Property(property: 'description', type: 'string', maxLength: 16383),
    ]),
)]
final class PostUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'description' => ['string', 'max:16383'],
        ];
    }
}
