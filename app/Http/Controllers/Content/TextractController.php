<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Services\TextractService;
use App\Http\Controllers\Controller;

class TextractController extends Controller
{
    protected $textractService;

    public function __construct(TextractService $textractService)
    {
        $this->textractService = $textractService;
    }

    public function processImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->getRealPath();
        $text = $this->textractService->extractText($imagePath);

        return response()->json(['extracted_text' => $text]);
    }
}
