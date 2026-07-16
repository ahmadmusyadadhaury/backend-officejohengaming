<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\MimeType;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show(string $path): Response
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return response()->view('file-missing', [], 404);
        }

        $file = $disk->get($path);
        $mime = MimeType::guess($path) ?? 'application/octet-stream';
        $isImage = str_starts_with($mime, 'image/');

        $headers = [
            'Content-Type' => $mime,
            'Content-Length' => strlen($file),
            'Cache-Control' => 'public, max-age=86400',
            'Content-Disposition' => $isImage ? 'inline' : 'attachment; filename="'.basename($path).'"',
        ];

        return response($file, 200, $headers);
    }
}
