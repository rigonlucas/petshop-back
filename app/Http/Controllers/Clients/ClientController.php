<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Services\Application\Clients\ClientListService;
use App\Services\Application\Clients\ClientShowService;
use App\Services\Application\Clients\DTO\ClientListData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    public function index(Request $request, ClientListService $service): AnonymousResourceCollection
    {
        $data = ClientListData::fromRequest($request);
        $schedules = $service->list($data, $request->user()->account_id);

        return ClientResource::collection($schedules);
    }

    public function show(Request $request, int $clientId, ClientShowService $service): ClientResource
    {
        $includes = $request->query('include', '');

        $client = $service
            ->setRequestedIncludes(explode(',', $includes))
            ->show($clientId);

        return ClientResource::make($client);
    }
}
