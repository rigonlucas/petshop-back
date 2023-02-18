<?php

namespace App\Http\Controllers\Pet;

use App\Actions\Application\Pets\DTO\PetListData;
use App\Actions\Application\Pets\PetListAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pet\PetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PetListController extends Controller
{
    /**
     * @param Request $request
     * @param PetListAction $service
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request, PetListAction $service): AnonymousResourceCollection
    {
        $data = PetListData::fromRequest($request);

        $schedules = $service->list($data);

        return PetResource::collection($schedules);
    }
}
