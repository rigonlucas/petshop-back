<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Client\ClientStoreRequest;
use App\Services\Application\Clients\ClientUpdateService;
use App\Services\Application\Clients\DTO\ClientUpdateData;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientUpdateController extends Controller
{
    /**
     * @param ClientStoreRequest $request
     * @param int $id
     * @param ClientUpdateService $service
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function __invoke(ClientStoreRequest $request, int $id, ClientUpdateService $service): JsonResponse
    {
        $this->authorize('client_update');
        $data = ClientUpdateData::fromRequest($request);
        $data->account_id = $request->user()->account_id;
        $data->id = $id;

        $result = DB::transaction(function () use ($service, $data) {
            return $service->update($data);
        });
        return response()->json(['data' => $result], ResponseAlias::HTTP_CREATED);
    }
}
