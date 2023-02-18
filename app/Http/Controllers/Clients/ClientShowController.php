<?php

namespace App\Http\Controllers\Clients;

use App\Actions\Application\Clients\ClientShowAction;
use App\Actions\Application\Clients\DTO\ClientShowData;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Request;

class ClientShowController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ClientShowAction $service
     * @return ClientResource
     */
    public function __invoke(Request $request, int $id, ClientShowAction $service): ClientResource
    {
        $data = ClientShowData::fromRequest($request);
        $data->id = $id;
        $data->account_id = $request->user()->account_id;
        $data->include = $request->query('include');

        $client = $service->show($data);

        return ClientResource::make($client);
    }
}
