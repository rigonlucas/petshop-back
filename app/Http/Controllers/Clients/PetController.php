<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pet\PetResource;
use App\Services\Application\Pets\DTO\PetListData;
use App\Services\Application\Pets\PetsListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PetController extends Controller
{
    public function index(Request $request, PetsListService $service): AnonymousResourceCollection
    {
        $data = PetListData::fromRequest($request);

        $schedules = $service
            ->accountPets($data)
            ->getQuery()
            ->paginate($data->per_page ?? 10);
        return PetResource::collection($schedules);
    }
}
