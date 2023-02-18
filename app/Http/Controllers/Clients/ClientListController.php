<?php

namespace App\Http\Controllers\Clients;

use App\Actions\Application\Clients\ClientListAction;
use App\Actions\Application\Clients\DTO\ClientListData;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientListController extends Controller
{
    /**
     * @param Request $request
     * @param ClientListAction $service
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request, ClientListAction $service): AnonymousResourceCollection
    {
        $data = ClientListData::fromRequest($request);
        $schedules = $service->list($data, $request->user()->account_id);

        return ClientResource::collection($schedules);
    }
}
