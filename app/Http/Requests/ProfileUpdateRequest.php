<?php

namespace App\Http\Requests;

use App\Rules\RekognitionRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use OpenApi\Attributes as OAT;

#[OAT\RequestBody(
    request: 'ProfileUpdateRequest',
    content: [
        new OAT\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OAT\Schema(required: ['_method'], properties: [
                new OAT\Property(property: '_method', type: 'string', example: 'PATCH'),
                new OAT\Property(property: 'title', type: 'string', maxLength: 255, nullable: true),
                new OAT\Property(property: 'description', type: 'string', maxLength: 16383, nullable: true),
                new OAT\Property(property: 'url', type: 'string', maxLength: 255, nullable: true),
                new OAT\Property(property: 'image', type: 'string', format: 'binary', maximum: 20480, nullable: true),
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
final class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:16383'],
            'url' => ['nullable', 'url', 'max:255'],
            'image' => [
                'nullable',
                File::types(['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])->max(20 * 1024),
                Rule::dimensions()->maxWidth(4096)->maxHeight(4096),
                new RekognitionRule,
            ],
        ];
    }
}
