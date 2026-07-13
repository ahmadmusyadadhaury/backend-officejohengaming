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

        if (! file_exists($fullPath) || ! is_readable($fullPath)) {
            abort(404);
        }

        $mimeType = function_exists('mime_content_type')
            ? (mime_content_type($fullPath) ?: 'application/octet-stream')
            : 'application/octet-stream';

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
