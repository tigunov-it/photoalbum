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
            schema: new OAT\Schema(required: ['album_id', 'images[]'], properties: [
                new OAT\Property(property: 'album_id', type: 'integer', format: 'int64', minimum: 1),
                new OAT\Property(property: 'titles[]', type: 'array', items: new OAT\Items(type: 'string', maxLength: 255)),
                new OAT\Property(property: 'descriptions[]', type: 'array', items: new OAT\Items(type: 'string', maxLength: 16383)),
                new OAT\Property(property: 'images[]', type: 'array', items: new OAT\Items(type: 'string', format: 'binary', maximum: 10240)),
            ]),
            encoding: [
                'images[*]' => ['contentType' => [
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
            'titles' => ['array'],
            'titles.*' => ['string', 'max:255'],
            'descriptions' => ['array'],
            'descriptions.*' => ['string', 'max:16383'],
            'images' => ['required', 'array'],
            'images.*' => [
                File::types(['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])->max(10 * 1024),
                Rule::dimensions()->maxWidth(4096)->maxHeight(4096),
                new RekognitionRule,
            ],
        ];
    }
}