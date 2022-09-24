<?php

namespace Database\Seeders;

use App\Enums\VaccinesTypesEnum;
use App\Models\Products\Vaccine;
use Illuminate\Database\Seeder;

class PetVaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vaccine::query()
            ->insert([
                [
                    'name' => 'Vacina Polivalente (V10)',
                    'type' => VaccinesTypesEnum::DOG->value,
                    'days_to_booster_dose' => 1,
                    'description' => 'Cinomose,Parvovirose,Coronavirose,Hepatite Infecciosa Canina,Adenovirose, Parainfluenza Canina e Leptospirose Canina.'
                ],
                [
                    'name' => 'Antirrábica',
                    'type' => VaccinesTypesEnum::DOG->value,
                    'days_to_booster_dose' => 1,
                    'description' => ''
                ],
                [
                    'name' => 'Vacina contra a gripe (Tosse dos Canis)',
                    'type' => VaccinesTypesEnum::DOG->value,
                    'days_to_booster_dose' => 1,
                    'description' => ''
                ],
                [
                    'name' => 'Vacina contra Giárdia',
                    'type' => VaccinesTypesEnum::DOG->value,
                    'days_to_booster_dose' => 1,
                    'description' => ''
                ],
                [
                    'name' => 'Vacina contra Leishmaniose',
                    'type' => VaccinesTypesEnum::DOG->value,
                    'days_to_booster_dose' => 1,
                    'description' => ''
                ],
                [
                    'name' => 'Parainfluenza Canina',
                    'type' => VaccinesTypesEnum::DOG->value,
                    'days_to_booster_dose' => 1,
                    'description' => ''
                ],
                [
                    'name' => 'Leptospirose Canina',
                    'type' => VaccinesTypesEnum::DOG->value,
                    'days_to_booster_dose' => 1,
                    'description' => ''
                ],
            ]);
    }
}
