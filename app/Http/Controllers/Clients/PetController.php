<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pet\PetResource;
use App\Services\App\Pets\PetsListService;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(Request $request, PetsListService $service)
    {
        $includes = $request->query('include', '');
        $perPage = $request->query('per_page', 10);
        $name = $request->query('name');
        $clientId = $request->query('client_id');

        $schedules = $service
            ->setRequestedIncludes(explode(',', $includes))
            ->accountPets()
            ->filterByName($name)
            ->filterByClient($clientId)
            ->getQuery()
            ->paginate($perPage);
        return PetResource::collection($schedules);
    }
}
