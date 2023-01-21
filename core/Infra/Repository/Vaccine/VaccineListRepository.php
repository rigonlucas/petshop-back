<?php

namespace Core\Infra\Repository\Vaccine;

use App\Models\Products\Vaccine;
use Core\Generics\Pagination\PaginationInput;
use Core\Modules\App\Vaccine\List\Collections\VaccineCollection;
use Core\Modules\App\Vaccine\List\Entities\Vaccine as VaccineEntity;
use Core\Modules\App\Vaccine\List\Exceptions\VaccineListDatabaseException;
use Core\Modules\App\Vaccine\List\Inputs\VaccineInput;
use Core\Modules\App\Vaccine\List\Pagination\ListOfVaccinesPagiantion;
use Core\Modules\Generics\App\Vaccine\Gateways\VaccineInterface;
use Exception;

class VaccineListRepository implements VaccineInterface
{

    public function listOfVaccines(VaccineInput $input, PaginationInput $paginationInput): ListOfVaccinesPagiantion
    {
        $page = $paginationInput->getPage() ?: 1;
        $perPage = $paginationInput->getPerPage() ?: 15;
        try {
            $vaccinesPaginated = Vaccine::query()
                ->when($input->nome, function ($query) use ($input) {
                    $query->where('name', '=', $input->nome);
                })
                ->paginate(
                    $perPage,
                    ['*'],
                    'page',
                    $page
                )->appends(['per_page' => $perPage, 'page' => $page]);
        } catch (Exception $exception) {
            throw new VaccineListDatabaseException($exception);
        }

        $vaccineCollection = new VaccineCollection();
        foreach ($vaccinesPaginated as $item) {
            $vaccineCollection->add(
                new VaccineEntity(
                    $item->id,
                    $item->name,
                    $item->type,
                    $item->number_first_shoot,
                    $item->number_first_shoot_days,
                    $item->days_to_booster_dose,
                    $item->created_at,
                    $item->updated_at,
                )
            );
        }
        
        return new ListOfVaccinesPagiantion(
            $vaccineCollection,
            $vaccinesPaginated->perPage(),
            $vaccinesPaginated->currentPage(),
            $vaccinesPaginated->total(),
            $vaccinesPaginated->lastPage()
        );
    }
}