<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Client\ClientStoreRequest;
use App\Services\Application\Clients\ClientUpdateService;
use App\Services\Application\Clients\DTO\ClientUpdateData;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientUpdateController extends Controller
{
    /**
     * @param ClientStoreRequest $request
     * @param int $id
     * @param ClientUpdateService $service
     * @return JsonResponse
     */
    public function __invoke(ClientStoreRequest $request, int $id, ClientUpdateService $service): JsonResponse
    {
        $data = ClientUpdateData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $data->id = $id;

        $client = $service->update($data);
        return response()->json(['data' => $client], ResponseAlias::HTTP_CREATED);
    }
}
