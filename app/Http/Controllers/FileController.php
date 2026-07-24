<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show(Request $request, string $path): Response
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return response()->view('file-missing', [], 404);
        }

        $file = $disk->get($path);
        $finfo = new \Finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($file) ?: 'application/octet-stream';
        $isImage = str_starts_with($mime, 'image/');
        $inline = $request->boolean('inline');

        $headers = [
            'Content-Type' => $mime,
            'Content-Length' => strlen($file),
            'Cache-Control' => 'public, max-age=86400',
            'Content-Disposition' => ($isImage || $inline) ? 'inline' : 'attachment; filename="'.basename($path).'"',
        ];

        return response($file, 200, $headers);
    }

    public function check(string $path): JsonResponse
    {
        $exists = Storage::disk('public')->exists($path);

        return response()->json(['exists' => $exists]);
    }
}
