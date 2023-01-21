<?php

namespace Core\Modules\App\Vaccine\List\Presenters\Collections;

use Core\Modules\App\Vaccine\List\Collections\vaccineCollection;
use Core\Modules\App\Vaccine\List\Entities\Vaccine;

class EntityCollectionPresenter
{
    private vaccineCollection $idpCollection;
    private array $presenter = [];

    public function __construct(vaccineCollection $idpCollection)
    {
        $this->idpCollection = $idpCollection;
    }

    public function present(): self
    {
        /** @var Vaccine $entity */
        foreach ($this->idpCollection->all() as $entity) {
            $this->presenter[] = [
                'id' => $entity->id,
                'nome' => $entity->name,
                'type' => $entity->type,
                'number_first_shoot' => $entity->numberFirstShoot,
                'number_first_shoot_days' => $entity->numberFirstShootDays,
                'days_to_booster_dose' => $entity->daysToBoosterDose,
                'created_at' => $entity->createdAt,
                'updated_at' => $entity->updatedAt,
            ];
        }
        return $this;
    }

    public function toArray(): array
    {
        return $this->presenter;
    }
}