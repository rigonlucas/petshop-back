<?php

namespace Tests\Unit\Core\Modules\Exemples;

use Core\Generics\Pagination\PaginationInput;
use Core\Modules\Examples\List\Collections\EntityCollection;
use Core\Modules\Examples\List\Gateways\EntityInterface;
use Core\Modules\Examples\List\Inputs\ConfigInput;
use Core\Modules\Examples\List\Inputs\EntityInput;
use Core\Modules\Examples\List\ListUseCase;
use Core\Modules\Examples\List\Pagination\EntityPagiantion;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class UseCaseTest extends TestCase
{
    public function test_example()
    {
        $repositoryMock = $this->createMock(EntityInterface::class);
        $usecase = new ListUseCase(
            $this->createMock(LoggerInterface::class),
            $repositoryMock
        );
        $repositoryMock->expects(self::once())->method('list')->willReturn(
            new EntityPagiantion(new EntityCollection(), 1, 1, 1,  1)
        );

        $usecase->execute(
            new EntityInput('aa'),
            new ConfigInput('', ''),
            new PaginationInput(1, 2)
        );

        $output = $usecase->getOutput();
        dd($output);
    }
}
