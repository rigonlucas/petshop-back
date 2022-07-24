<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Breed\BreedResource;
use App\Services\App\Breeds\BreedsListService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BreedController extends Controller
{
    public function index(Request $request, BreedsListService $service): AnonymousResourceCollection
    {
        $schedules = $service
            ->breeds()
            ->filterByType($request->query('type'))
            ->getQuery()
            ->paginate($request->query('per_page', 10));
        return BreedResource::collection($schedules);
    }
}
