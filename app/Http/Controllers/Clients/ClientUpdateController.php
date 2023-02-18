<?php

namespace App\Http\Controllers\Clients;

use App\Actions\Application\Clients\ClientUpdateAction;
use App\Actions\Application\Clients\DTO\ClientUpdateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Client\ClientStoreRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientUpdateController extends Controller
{
    /**
     * @param ClientStoreRequest $request
     * @param int $id
     * @param ClientUpdateAction $service
     * @return JsonResponse
     */
    public function __invoke(ClientStoreRequest $request, int $id, ClientUpdateAction $service): JsonResponse
    {
        $data = ClientUpdateData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $data->id = $id;

        $client = $service->update($data);
        return response()->json(['data' => $client], ResponseAlias::HTTP_CREATED);
    }
}
