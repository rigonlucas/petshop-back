<?php

namespace Core\Modules\App\Vaccine\List\Entities;

use DateTimeInterface;

class Vaccine
{
    public function __construct(
        readonly int $id,
        readonly string $name,
        readonly string $type,
        readonly int $numberFirstShoot,
        readonly int $numberFirstShootDays,
        readonly int $daysToBoosterDose,
        readonly DateTimeInterface $createdAt,
        readonly DateTimeInterface $updatedAt,
    ) {
    }
}