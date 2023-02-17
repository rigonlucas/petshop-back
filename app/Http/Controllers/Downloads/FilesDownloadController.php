<?php

namespace App\Http\Controllers\Downloads;

use App\Enums\Exports\StorageExportEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Storage;

class FilesDownloadController extends Controller
{
    public function __invoke()
    {
        $path = request()->get('path');

        $disk = Storage::disk(StorageExportEnum::PRIVATE_DISK->value);
        $path = $disk->path($path);

        $isValidSignature = app(UrlGenerator::class)->hasValidSignature(request());
        if (!$isValidSignature) {
            return abort(403, 'Url inválida');
        }
        ob_end_clean();

        return response()->download($path);


        //return Storage::disk('public')->download($path);
        return new Response(file_get_contents($path), 200, [
            'Content-Type' => Storage::mimeType($path),
            'Content-Disposition' => 'attachment; filename="' . basename($path) . '"',
        ]);
    }
}
