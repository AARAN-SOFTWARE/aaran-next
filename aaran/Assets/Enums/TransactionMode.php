<?php

namespace Aaran\Assets\Enums;

enum TransactionMode: int
{
    case PAYMENT = 1;
    case RECEIPT = 2;
    case UNKNOWN = 3;

    public function getName(): string
    {
        return match ($this) {
            self::PAYMENT => 'Payment',
            self::RECEIPT => 'Receipt',
            self::UNKNOWN => 'Unknown',
        };
    }
}
