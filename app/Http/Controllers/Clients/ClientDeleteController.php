<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Services\Application\Clients\ClientDeleteService;
use App\Services\Application\Clients\DTO\ClientDeleteData;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientDeleteController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ClientDeleteService $service
     * @return Response
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, int $id, ClientDeleteService $service): Response
    {
        $this->authorize('client_delete');
        $data = new ClientDeleteData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
