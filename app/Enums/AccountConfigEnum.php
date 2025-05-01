<?php

namespace App\Enums;

enum AccountConfigEnum : string
{
    case WORKING = 'Working';
    case ERROR = 'Error';
    
    /**
     * GET Badge Name from the value
     * @param int $value
     */
    public static function fromInt(int $value): ?self
    {
        return match ($value) {
            1 => self::WORKING,
            2 => self::ERROR,
            default => null,
        };
    }

    /**
     * Get Badge Class from the value
     * @param self $value
     */
    public static function badgeClass(self $value): string
    {
        return match ($value) {
            self::WORKING => 'badge-warning',
            self::ERROR => 'badge-danger',
        };
    }

    /**
     * GET Value from the Status
     * @param string $status
     */
    public static function getApiStatus(self $status): ?int
    {
        return match ($status) {
            self::WORKING => 1,
            self::ERROR => 2,
        };
    }
}
