<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Services\Application\Clients\ClientShowService;
use App\Services\Application\Clients\DTO\ClientShowData;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ClientShowController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ClientShowService $service
     * @return ClientResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, int $id, ClientShowService $service): ClientResource
    {
        $this->authorize('client_show');
        $data = ClientShowData::fromRequest($request);
        $data->id = $id;
        $data->account_id = $request->user()->account_id;
        $data->include = $request->query('include');

        $client = $service->show($data);

        return ClientResource::make($client);
    }
}
