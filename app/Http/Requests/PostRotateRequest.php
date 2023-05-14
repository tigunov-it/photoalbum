<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OAT;

#[OAT\RequestBody(
    request: 'PostRotateRequest',
    required: false,
    content: new OAT\JsonContent(properties: [
        new OAT\Property(property: 'size', description: 'Returning image size', type: 'string', enum: self::SIZES),
        new OAT\Property(property: 'angle', type: 'number', format: 'float', default: 90, maximum: 360, minimum: -360),
        new OAT\Property(property: 'bgcolor', type: 'string', default: '#ffffff', pattern: '/^#?([a-f0-9]{1,2})([a-f0-9]{1,2})([a-f0-9]{1,2})$/i'),
    ]),
)]
final class PostRotateRequest extends FormRequest
{
    /**
     * @var string[]
     */
    private const SIZES = ['S', 'M', 'L'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'size' => ['string', Rule::in(self::SIZES)],
            'angle' => ['numeric', 'between:-360,360'],
            'bgcolor' => ['string', 'regex:/^#?([a-f0-9]{1,2})([a-f0-9]{1,2})([a-f0-9]{1,2})$/i'],
        ];
    }
}
