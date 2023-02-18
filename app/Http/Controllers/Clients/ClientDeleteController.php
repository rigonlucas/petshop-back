<?php

namespace App\Http\Controllers\Clients;

use App\Actions\Application\Clients\ClientDeleteAction;
use App\Actions\Application\Clients\DTO\ClientDeleteData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientDeleteController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param ClientDeleteAction $service
     * @return Response
     */
    public function __invoke(Request $request, int $id, ClientDeleteAction $service): Response
    {
        $data = new ClientDeleteData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
