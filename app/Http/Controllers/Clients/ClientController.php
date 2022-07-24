<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Services\Application\Clients\ClientListService;
use App\Services\Application\Clients\ClientShowService;
use App\Services\Application\Clients\DTO\BreedListData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{

    public function index(Request $request, ClientListService $service): AnonymousResourceCollection
    {
        $data = BreedListData::fromRequest($request);
        $schedules = $service
            ->accountClients($data)
            ->getQuery()
            ->paginate($data->per_page ?? 10);
        return ClientResource::collection($schedules);
    }

    public function show(Request $request, int $clientId, ClientShowService $service): ClientResource
    {
        $includes = $request->query('include', '');

        $clientPets = $service
            ->setRequestedIncludes(explode(',', $includes))
            ->accountClient($clientId)
            ->getQuery()
            ->first();

        return ClientResource::make($clientPets);
    }
}
