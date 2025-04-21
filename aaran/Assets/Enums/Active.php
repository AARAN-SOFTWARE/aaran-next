<?php

namespace Aaran\Assets\Enums;

enum Active: int
{
    case ACTIVE = 1;
    case NOT_ACTIVE = 2;
    case UNKNOW = 3;

    public function getName(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::NOT_ACTIVE => 'Not_active',
            self::UNKNOW => 'Unknow',
        };
    }
}
