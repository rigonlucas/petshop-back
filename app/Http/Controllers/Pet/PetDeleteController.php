<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Services\Application\Pets\DTO\PetDeleteData;
use App\Services\Application\Pets\PetDeleteService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PetDeleteController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param PetDeleteService $service
     * @return Response
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, int $id, PetDeleteService $service): Response
    {
        $this->authorize('client_delete');
        $data = new PetDeleteData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
