<?php

namespace App\Enums;

enum ProductsEnum: int
{
    case SERVICE = 1;
    case PRODUCT = 2;

    /**
     * @throws \Exception
     */
    public static function random(): int
    {
        return array_rand([
            self::PRODUCT->value,
            self::SERVICE->value
        ]);
    }
}