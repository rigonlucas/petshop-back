<?php

namespace Core\Modules\App\Vaccine\List\Collections;


use Core\Generics\Collections\BaseCollection\BaseCollection;
use Core\Modules\App\Vaccine\List\Entities\Vaccine;

class VaccineCollection extends BaseCollection
{
    public function add(Vaccine $vaccine): void
    {
        $this->collector[] = $vaccine;
    }
}