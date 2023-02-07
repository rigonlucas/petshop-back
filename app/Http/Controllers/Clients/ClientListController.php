<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Services\Application\Clients\ClientListService;
use App\Services\Application\Clients\DTO\ClientListData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientListController extends Controller
{
    /**
     * @param Request $request
     * @param ClientListService $service
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request, ClientListService $service): AnonymousResourceCollection
    {
        $data = ClientListData::fromRequest($request);
        $schedules = $service->list($data, $request->user()->account_id);

        return ClientResource::collection($schedules);
    }
}
