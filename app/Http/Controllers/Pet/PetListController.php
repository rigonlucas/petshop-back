<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pet\PetResource;
use App\Services\Application\Pets\DTO\PetListData;
use App\Services\Application\Pets\PetListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PetListController extends Controller
{
    public function __invoke(Request $request, PetListService $service): AnonymousResourceCollection
    {
        $data = PetListData::fromRequest($request);

        $schedules = $service->list($data);

        return PetResource::collection($schedules);
    }
}
