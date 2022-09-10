<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pet\PetResource;
use App\Services\Application\Pets\DTO\PetListData;
use App\Services\Application\Pets\PetListService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PetListController extends Controller
{
    /**
     * @param Request $request
     * @param PetListService $service
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, PetListService $service): AnonymousResourceCollection
    {
        $abort = $request->user()->hasAnyPermission(['client_access', 'schedule_create', 'schedule_update']);
        abort_if(!$abort, 403);
        $data = PetListData::fromRequest($request);

        $schedules = $service->list($data);

        return PetResource::collection($schedules);
    }
}
