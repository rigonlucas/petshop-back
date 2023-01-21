<?php

namespace Tests\Unit\Core\Modules\Exemples;

use Core\Generics\Enums\ResponseEnum;
use Core\Generics\Outputs\Errors\ErrorOutput;
use Core\Generics\Outputs\StatusOutput;
use Core\Generics\Pagination\PaginationInput;
use Core\Modules\Examples\List\Collections\EntityCollection;
use Core\Modules\Examples\List\Entities\Entity;
use Core\Modules\Examples\List\Enums\ErrorCodeEnum;
use Core\Modules\Examples\List\Exceptions\EntityDatabaseException;
use Core\Modules\Examples\List\Exceptions\EntityValidationException;
use Core\Modules\Examples\List\Gateways\EntityInterface;
use Core\Modules\Examples\List\Inputs\ConfigInput;
use Core\Modules\Examples\List\Inputs\EntityInput;
use Core\Modules\Examples\List\ListUseCase;
use Core\Modules\Examples\List\Outputs\ListEntitiesOutput;
use Core\Modules\Examples\List\Pagination\EntityPagiantion;
use Exception;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class UseCaseTest extends TestCase
{
    public function test_example()
    {
        $repositoryMock = $this->createMock(EntityInterface::class);
        $usecase = new ListUseCase(
            $this->createMock(LoggerInterface::class),
            $repositoryMock
        );
        $entityCollection = new EntityCollection();
        $entityCollection->add(
            new Entity(
                1,
                'teste',
                'emil@teste',
                now(),
                'foto.png'
            )
        );
        $repositoryMock->expects(self::once())
            ->method('list')
            ->willReturn(new EntityPagiantion($entityCollection, 1, 1, 1, 1));

        $usecase->execute(
            new EntityInput('email@email.com'),
            new ConfigInput('public', 'usuario/foto'),
            new PaginationInput(1, 2)
        );

        $output = $usecase->getOutput();
        $this->assertEquals(
            new ListEntitiesOutput(
                new StatusOutput(ResponseEnum::OK, ResponseEnum::OK->getCodeName()),
                new EntityPagiantion($entityCollection, 1, 1, 1, 1)
            ),
            $output
        );
    }

    public function test_example_generic_exception_throw()
    {
        $repositoryMock = $this->createMock(EntityInterface::class);
        $usecase = new ListUseCase(
            $this->createMock(LoggerInterface::class),
            $repositoryMock
        );
        $repositoryMock->expects(self::once())
            ->method('list')
            ->willThrowException(new EntityDatabaseException(new Exception()));

        $usecase->execute(
            new EntityInput('aa'),
            new ConfigInput('', ''),
            new PaginationInput(1, 2)
        );
        $output = $usecase->getOutput();
        $this->assertEquals(
            new ErrorOutput(
                new StatusOutput(
                    ResponseEnum::INTERNAL_SERVER_ERROR,
                    ResponseEnum::INTERNAL_SERVER_ERROR->getCodeName()
                ),
                ErrorCodeEnum::ENTITY__LIST__GENERIC_EXCEPTION->value,
                ErrorCodeEnum::ENTITY__LIST__GENERIC_EXCEPTION->getErrorCode()
            ),
            $output
        );
    }

    public function test_example_validation_exception_throw()
    {
        $repositoryMock = $this->createMock(EntityInterface::class);
        $usecase = new ListUseCase(
            $this->createMock(LoggerInterface::class),
            $repositoryMock
        );
        $repositoryMock->expects(self::once())
            ->method('list')
            ->willThrowException(new EntityValidationException(new Exception()));

        $usecase->execute(
            new EntityInput('aa'),
            new ConfigInput('', ''),
            new PaginationInput(1, 2)
        );
        $output = $usecase->getOutput();

        $this->assertEquals(
            new ErrorOutput(
                new StatusOutput(
                    ResponseEnum::UNPROCESSABLE_ENTITY,
                    ResponseEnum::UNPROCESSABLE_ENTITY->getCodeName()
                ),
                ErrorCodeEnum::ENTITY__LIST__VALIDATION_EXCEPTION->value,
                ErrorCodeEnum::ENTITY__LIST__VALIDATION_EXCEPTION->getErrorCode(),
                (new EntityValidationException(new Exception()))->getValidationErrors()
            ),
            $output
        );
    }
}
