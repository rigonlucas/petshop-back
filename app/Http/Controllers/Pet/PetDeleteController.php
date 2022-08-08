<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Services\Application\Pets\DTO\PetDeleteData;
use App\Services\Application\Pets\PetDeleteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PetDeleteController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request, int $id, PetDeleteService $service): Response
    {
        $data = new PetDeleteData();
        $data->id = $id;
        $data->account_id = $request->user()->account_id;

        $service->delete($data);
        return response()->noContent();
    }
}
