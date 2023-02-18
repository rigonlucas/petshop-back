<?php

namespace App\Http\Controllers\Pet;

use App\Actions\Application\Pets\DTO\PetDeleteData;
use App\Actions\Application\Pets\PetDeleteAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PetDeleteController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param PetDeleteAction $service
     * @return Response
     * @throws ValidationException
     */
    public function __invoke(Request $request, int $id, PetDeleteAction $service): Response
    {
        $data = new PetDeleteData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
