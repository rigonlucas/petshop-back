<?php

namespace App\Http\Controllers\Pet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pet\PetResource;
use App\Services\Application\Pets\DTO\PetShowData;
use App\Services\Application\Pets\PetShowService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PetShowController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @param PetShowService $service
     * @return PetResource
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, int $id, PetShowService $service): PetResource
    {
        $data = PetShowData::fromRequest($request);
        $data->id = $id;
        $data->account_id = $request->user()->account_id;
        $pet = $service->show($data);
        return PetResource::make($pet);
    }
}
