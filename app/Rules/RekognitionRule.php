<?php

namespace App\Rules;

use App\Services\RekognitionService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

final class RekognitionRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value instanceof UploadedFile) {
            $resultLabels = app(RekognitionService::class)->moderate($value);

            if (!empty($resultLabels)) {
                $fail('validation-custom.banned_content')->translate([
                    'banned' => implode(", ", array_column($resultLabels, 'Name')),
                ]);
            }
        }
    }
}
