<?php

namespace App\Actions\Filters\Rules;

use App\Actions\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class WhereLikeFilter implements FilterInterface
{
    private string $leftOperatorChar;
    private string $rightOperatorChar;

    private array $operatorsAvailables = [
        'like',
        'not like'
    ];

    public function __construct(
        private readonly string $column,
        private readonly string $likeOperator = 'like',
        private readonly bool $left = true,
        private readonly bool $right = true
    )
    {
        $this->leftOperatorChar = $this->left ? '%' : '';
        $this->rightOperatorChar = $this->right ? '%' : '';
        if (!in_array($this->likeOperator, $this->operatorsAvailables)){
            throw new \Exception('Operador inválido no filtro where like');
        }
    }

    public function filter(Builder $builder, $value): void
    {
        if (!$value) {
            return;
        }

        $builder->where($this->column, $this->likeOperator, $this->leftOperatorChar . $value . $this->rightOperatorChar);
    }
}