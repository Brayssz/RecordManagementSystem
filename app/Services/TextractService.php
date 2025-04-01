<?php

namespace App\Services;

use Aws\Textract\TextractClient;

class TextractService
{
    protected $client;

    public function __construct()
    {
        $this->client = new TextractClient([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    public function extractText($imagePath)
    {
        $imageData = fopen($imagePath, 'r');

        $result = $this->client->detectDocumentText([
            'Document' => ['Bytes' => stream_get_contents($imageData)],
        ]);

        fclose($imageData);

        $text = [];
        foreach ($result['Blocks'] as $block) {
            if ($block['BlockType'] === 'LINE') {
                $text[] = $block['Text'];
            }
        }

        return implode("\n", $text);
    }
}