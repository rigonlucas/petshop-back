<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Client\ClientStoreRequest;
use App\Services\Application\Clients\ClientStoreService;
use App\Services\Application\Clients\DTO\ClientStoreData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientStoreController extends Controller
{
    /**
     * @param ClientStoreRequest $request
     * @param ClientStoreService $service
     * @return JsonResponse
     */
    public function __invoke(ClientStoreRequest $request, ClientStoreService $service)
    {
        $data = ClientStoreData::fromRequest($request);
        $data->account_id = $request->user()->account_id;

        $result = DB::transaction(function () use ($service, $data) {
            return $service->store($data);
        });
        return response()->json([$result], ResponseAlias::HTTP_CREATED);
    }
}
