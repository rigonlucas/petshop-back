<?php

namespace App\Http\Controllers\Vaccines;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\VaccineResource;
use App\Services\Application\Vaccines\DTO\VaccinesListData;
use App\Services\Application\Vaccines\VaccinesListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class VaccinesListController extends Controller
{
    public function __invoke(Request $request, VaccinesListService $service): AnonymousResourceCollection
    {
        $abort = $request->user()->hasAnyPermission([
            'client_access', 'schedule_create', 'schedule_update', 'schedule_show', 'vaccine_access'
        ]);
        abort_if(!$abort, 403);
        $data = VaccinesListData::fromRequest($request);
        $vaccines = Cache::rememberForever('vaccines', function () use ($data, $service) {
            return $service->list($data);
        });
        return VaccineResource::collection($vaccines);
    }
}
