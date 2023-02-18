<?php

namespace App\Http\Controllers\Clients;

use App\Actions\Application\Clients\ClientStoreAction;
use App\Actions\Application\Clients\DTO\ClientStoreData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Client\ClientStoreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientStoreController extends Controller
{
    /**
     * @param ClientStoreRequest $request
     * @param ClientStoreAction $service
     * @return JsonResponse
     */
    public function __invoke(ClientStoreRequest $request, ClientStoreAction $service)
    {
        $data = ClientStoreData::fromRequest($request);
        $data->account_id = $request->user()->account_id;

        $result = DB::transaction(function () use ($service, $data) {
            return $service->store($data);
        });
        return response()->json([$result], ResponseAlias::HTTP_CREATED);
    }
}
