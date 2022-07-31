<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Client\ClientStoreRequest;
use App\Services\Application\Clients\ClientDeleteService;
use App\Services\Application\Clients\ClientUpdateService;
use App\Services\Application\Clients\DTO\ClientDeleteData;
use App\Services\Application\Clients\DTO\ClientUpdateData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClientDeleteController extends Controller
{
    public function __invoke(Request $request, int $clientId, ClientDeleteService $service): Response
    {
        $data = new ClientDeleteData();
        $data->id = $clientId;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
