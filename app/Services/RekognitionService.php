<?php

namespace App\Services;

use Aws\Rekognition\RekognitionClient;
use Illuminate\Http\UploadedFile;

final readonly class RekognitionService
{
    private RekognitionClient $client;

    public function __construct()
    {
        $this->client = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
        ]);
    }

    public function moderate(UploadedFile $file)
    {
        return $this->client->detectModerationLabels([
            'Image' => ['Bytes' => $file],
            'MinConfidence' => 50
        ])->get('ModerationLabels');
    }
}
