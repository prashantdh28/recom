<?php

namespace App\Enums;

enum StatusEnum : string
{
    case ACTIVE = "Active";
    case IN_ACTIVE = "In Active";

    /**
     * Get an associative array of all statuses
     */
    public static function getStatus(): array
    {
        return [
            self::ACTIVE->value => 1,
            self::IN_ACTIVE->value => 0,
        ];
    }
}
