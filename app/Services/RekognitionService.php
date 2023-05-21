<?php

namespace App\Services;

use Aws\Rekognition\RekognitionClient;
use Illuminate\Http\UploadedFile;

final readonly class RekognitionService
{
    private RekognitionClient $client;

    private const MAX_FILE_SIZE = 5242880;

    public function __construct()
    {
        $this->client = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
        ]);
    }

    public function moderate(UploadedFile $file)
    {
        // $imageForAnalise = fopen($file, 'r');
        // $bytes = fread($imageForAnalise, filesize($file));
        $bytes = ImageService::getReducedImage($file, self::MAX_FILE_SIZE);

        return $this->client->detectModerationLabels([
            'Image' => ['Bytes' => $bytes],
            'MinConfidence' => 50
        ])->get('ModerationLabels');
    }
}
