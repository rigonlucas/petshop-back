<?php

namespace Tests\Unit\Core\Modules\App\Vaccine\List;

use Core\Generics\Enums\ResponseEnum;
use Core\Generics\Outputs\Errors\ErrorOutput;
use Core\Generics\Outputs\StatusOutput;
use Core\Generics\Pagination\PaginationInput;
use Core\Modules\App\Vaccine\List\Collections\VaccineCollection;
use Core\Modules\App\Vaccine\List\Entities\Vaccine;
use Core\Modules\App\Vaccine\List\Enums\ErrorCodeEnum;
use Core\Modules\App\Vaccine\List\Exceptions\VaccineListDatabaseException;
use Core\Modules\App\Vaccine\List\Inputs\VaccineInput;
use Core\Modules\App\Vaccine\List\ListVaccineUseCase;
use Core\Modules\App\Vaccine\List\Outputs\ListOfVaccinesOutput;
use Core\Modules\App\Vaccine\List\Pagination\ListOfVaccinesPagiantion;
use Core\Modules\Generics\App\Vaccine\Gateways\VaccineInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

/**
 * @group test_vaccine_list
 */
class ListOfVaccinesTest extends TestCase
{
    public function test_success_list_of_vaccines()
    {
        $input = new VaccineInput('nome da vacina');
        $paginationInput = new PaginationInput(10, 1);

        $vaccineCollection = new VaccineCollection();
        $vaccineCollection->add(
            new Vaccine(
                1,
                'twse',
                '1',
                1,
                1,
                1,
                now(),
                now()
            )
        );

        $vaccineRepositoryMock = $this->createMock(VaccineInterface::class);
        $vaccineRepositoryMock->expects(self::once())
            ->method('listOfVaccines')
            ->willReturn(
                new ListOfVaccinesPagiantion(
                    $vaccineCollection,
                    1,
                    1,
                    1,
                    1
                )
            );

        $useCase = new ListVaccineUseCase(
            $this->createMock(LoggerInterface::class),
            $vaccineRepositoryMock
        );

        $useCase->execute($input, $paginationInput);
        $this->assertEquals(
            new ListOfVaccinesOutput(
                new StatusOutput(ResponseEnum::OK, ResponseEnum::OK->getCodeName()),
                new ListOfVaccinesPagiantion($vaccineCollection, 1, 1, 1, 1)
            ),
            $useCase->getOutput()
        );
    }


    public function test_success_list_of_vaccines_database_exception()
    {
        $input = new VaccineInput('nome da vacina');
        $paginationInput = new PaginationInput(10, 1);

        $vaccineCollection = new VaccineCollection();
        $vaccineCollection->add(
            new Vaccine(
                1,
                'twse',
                '1',
                1,
                1,
                1,
                now(),
                now()
            )
        );

        $vaccineRepositoryMock = $this->createMock(VaccineInterface::class);
        $vaccineRepositoryMock->expects(self::once())
            ->method('listOfVaccines')
            ->willThrowException(
                new VaccineListDatabaseException(new Exception())
            );

        $useCase = new ListVaccineUseCase(
            $this->createMock(LoggerInterface::class),
            $vaccineRepositoryMock
        );

        $useCase->execute($input, $paginationInput);
        $this->assertEquals(
            new ErrorOutput(
                new StatusOutput(
                    ResponseEnum::INTERNAL_SERVER_ERROR,
                    ResponseEnum::INTERNAL_SERVER_ERROR->getCodeName()
                ),
                ErrorCodeEnum::ENTITY__LIST__DATA_BASE_EXCEPTION->value,
                ErrorCodeEnum::ENTITY__LIST__DATA_BASE_EXCEPTION->getErrorCode(),
            ),
            $useCase->getOutput()
        );
    }
}
