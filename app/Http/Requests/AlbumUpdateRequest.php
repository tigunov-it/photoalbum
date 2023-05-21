<?php

namespace App\Http\Requests;

use App\Rules\RekognitionRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use OpenApi\Attributes as OAT;

#[OAT\RequestBody(
    request: 'AlbumUpdateRequest',
    content: [
        new OAT\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OAT\Schema(required: ['_method'], properties: [
                new OAT\Property(property: '_method', enum: ['PUT', 'PATCH']),
                new OAT\Property(property: 'title', type: 'string', maxLength: 255),
                new OAT\Property(property: 'description', type: 'string', maxLength: 16383),
                new OAT\Property(property: 'image', type: 'string', format: 'binary', maximum: 20480),
                new OAT\Property(property: 'is_public', type: 'boolean', default: false),
            ]),
            encoding: [
                'image' => ['contentType' => [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/gif',
                    'image/bmp',
                    'image/x-bmp',
                    'image/x-ms-bmp',
                    'image/webp',
                ]],
            ],
        ),
    ],
)]
final class AlbumUpdateRequest extends FormRequest
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
            'image' => [
                File::types(['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])->max(20 * 1024),
                Rule::dimensions()->maxWidth(4096)->maxHeight(4096),
                new RekognitionRule,
            ],
            'is_public' => ['boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_public' => $this->boolean('is_public'),
        ]);
    }
}
