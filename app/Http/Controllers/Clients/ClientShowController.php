<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Services\Application\Clients\ClientShowService;
use App\Services\Application\Clients\DTO\ClientShowData;
use Illuminate\Http\Request;

class ClientShowController extends Controller
{
    public function __invoke(Request $request, int $id, ClientShowService $service): ClientResource
    {

        $includes = $request->query('include', '');
        $data = ClientShowData::fromRequest($request);
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $client = $service
            ->setRequestedIncludes(explode(',', $includes))
            ->show($data);

        return ClientResource::make($client);
    }
}
