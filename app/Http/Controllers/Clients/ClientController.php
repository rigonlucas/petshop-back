<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Services\App\Clients\ClientListService;
use App\Services\App\Clients\ClientShowService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{

    public function index(Request $request, ClientListService $service): AnonymousResourceCollection
    {
        $includes = $request->query('include', '');
        $schedules = $service
            ->setRequestedIncludes(explode(',', $includes))
            ->accountClients()
            ->getQuery()
            ->paginate($request->query('per_page', 10));
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
