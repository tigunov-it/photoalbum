<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OAT;

#[OAT\RequestBody(
    request: 'ProfileUpdateRequest',
    content: new OAT\JsonContent(required: ['title'], properties: [
        new OAT\Property(property: 'title', type: 'string', maxLength: 255),
        new OAT\Property(property: 'description', type: 'string', maxLength: 16383),
        new OAT\Property(property: 'url', type: 'string', maxLength: 255),
        new OAT\Property(property: 'image', type: 'string', maxLength: 255),
    ]),
)]
final class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        //! Fixme
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:16383'],
            'url' => ['string', 'max:255'],
            'image' => ['string', 'max:255'],
        ];
    }
}
