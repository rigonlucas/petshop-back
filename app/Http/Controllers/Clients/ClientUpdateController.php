<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Client\ClientStoreRequest;
use App\Services\Application\Clients\ClientUpdateService;
use App\Services\Application\Clients\DTO\ClientUpdateData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientUpdateController extends Controller
{
    public function __invoke(ClientStoreRequest $request, int $clientId, ClientUpdateService $service): JsonResponse
    {
        $data = ClientUpdateData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $data->id = $clientId;

        $result = DB::transaction(function () use ($service, $data) {
            return $service->update($data);
        });
        return response()->json([$result], ResponseAlias::HTTP_CREATED);
    }
}
