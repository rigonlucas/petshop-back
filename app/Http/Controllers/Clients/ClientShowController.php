<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Services\Application\Clients\ClientShowService;
use Illuminate\Http\Request;

class ClientShowController extends Controller
{
    public function __invoke(Request $request, int $clientId, ClientShowService $service): ClientResource
    {
        $includes = $request->query('include', '');

        $client = $service
            ->setRequestedIncludes(explode(',', $includes))
            ->show($clientId);

        return ClientResource::make($client);
    }
}
