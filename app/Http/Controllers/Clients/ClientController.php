<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Services\App\Clients\ClientListService;
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
            ->paginate($request->query('per_page', 10));
        return ClientResource::collection($schedules);
    }
}
