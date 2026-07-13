<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show(string $path): Response
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            abort(404);
        }

        $fullPath = $disk->path($path);
        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';

        $headers = [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ];

        return response()->file($fullPath, $headers);
    }
}
