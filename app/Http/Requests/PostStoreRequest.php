<?php

namespace App\Http\Requests;

use App\Models\Album;
use App\Rules\RekognitionRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use OpenApi\Attributes as OAT;

#[OAT\RequestBody(
    request: 'PostStoreRequest',
    content: [
        new OAT\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OAT\Schema(required: ['album_id', 'image'], properties: [
                new OAT\Property(property: 'album_id', type: 'integer', format: 'int64', minimum: 1),
                new OAT\Property(property: 'title', type: 'string', default: '', maxLength: 255, nullable: true),
                new OAT\Property(property: 'description', type: 'string', default: '', maxLength: 16383, nullable: true),
                new OAT\Property(property: 'image', type: 'string', format: 'binary', maximum: 5120),
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
final class PostStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'album_id' => [
                'required', 'integer', 'min:1',
                Rule::exists(Album::class, 'id')->where('user_id', $this->user()?->id),
            ],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:16383'],
            'image' => [
                'required',
                File::types(['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])->max(5 * 1024),
                Rule::dimensions()->maxWidth(4096)->maxHeight(4096),
                new RekognitionRule,
            ],
        ];
    }
}
