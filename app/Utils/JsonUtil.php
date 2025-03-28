<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class JsonUtil
{
    /**
     * Read JSON file from public/json/ and return its contents.
     *
     * @param string $filename
     * @return JsonResponse
     */
    public static function getJsonFromPublic(string $filename): JsonResponse
    {
        $path = public_path("json/{$filename}");

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->json(json_decode(file_get_contents($path), true));
    }
}
