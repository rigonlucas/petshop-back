<?php

namespace App\Http\Controllers\Vaccines;

use App\Http\Controllers\Controller;
use Core\Generics\Pagination\PaginationInput;
use Core\Infra\Repository\Vaccine\VaccineListRepository;
use Core\Modules\App\Vaccine\List\Inputs\VaccineInput;
use Core\Modules\App\Vaccine\List\ListVaccineUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Psr\Log\LoggerInterface;

class VaccinesListController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $input = new VaccineInput($request->input('name'));
        $paginationInput = new PaginationInput(
            $request->input('per_page', 10),
            $request->input('page', 1)
        );

        $useCase = new ListVaccineUseCase(
            App::make(LoggerInterface::class),
            new VaccineListRepository()
        );

        $useCase->execute($input, $paginationInput);
        return response()->json(
            $useCase->getOutput()->getPresenter()->toArray(),
            $useCase->getOutput()->getStatus()->getCode()
        );
        /*$abort = $request->user()->hasAnyPermission([
            'client_access',
            'schedule_create',
            'schedule_update',
            'schedule_show',
            'vaccine_access'
        ]);
        abort_if(!$abort, 403);
        $data = VaccinesListData::fromRequest($request);
        $vaccines = Cache::rememberForever('vaccines', function () use ($data, $service) {
            return $service->list($data);
        });
        return VaccineResource::collection($vaccines);*/
    }
}
