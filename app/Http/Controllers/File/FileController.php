<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    public function downloadFile($filename): BinaryFileResponse
    {
        if (!Storage::exists("public/avatar/{$filename}")) {
            abort(404);
        }

        $filePath = storage_path("app/public/avatar/{$filename}");

        return response()->download($filePath);
    }
}
