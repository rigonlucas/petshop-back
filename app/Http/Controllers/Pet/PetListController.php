<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pet\PetResource;
use App\Services\Application\Pets\DTO\PetListData;
use App\Services\Application\Pets\PetsListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PetListController extends Controller
{
    public function __invoke(Request $request, PetsListService $service): AnonymousResourceCollection
    {
        $data = PetListData::fromRequest($request);

        $schedules = $service
            ->accountPets($data)
            ->getQuery()
            ->paginate($data->per_page ?? 10);
        return PetResource::collection($schedules);
    }
}
