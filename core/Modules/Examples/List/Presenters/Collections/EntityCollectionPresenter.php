<?php

namespace Core\Modules\Examples\List\Presenters\Collections;

use Core\Modules\Examples\List\Collections\EntityCollection;
use Core\Modules\Examples\List\Entities\Entity;

class EntityCollectionPresenter
{
    private EntityCollection $idpCollection;
    private array $presenter = [];

    public function __construct(EntityCollection $idpCollection)
    {
        $this->idpCollection = $idpCollection;
    }

    public function present(): self
    {
        /** @var Entity $entity */
        foreach ($this->idpCollection->all() as $entity) {
            $this->presenter[] = [
                'id' => $entity->getId(),
                'nome' => $entity->getNome(),
                'email' => $entity->getEmail(),
                'foto' => $entity->getFoto(),
                'data_nascimento' => $entity->getDataNascimento(),
            ];
        }
        return $this;
    }

    public function toArray(): array
    {
        return $this->presenter;
    }
}