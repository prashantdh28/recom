<?php

namespace App\Enums;

enum ProductListEnum : string
{
    case ENROLLED = 'Enrolled';
    case IN_OPR = 'In OPR';
    case SCHEDULED_OPR = 'Scheduled OPR';
    case PROTECTED = 'Protected';
    
    /**
     * GET Badge Name from the value
     * @param int $value
     */
    public static function fromInt(int $value): ?self
    {
        return match ($value) {
            0 => self::ENROLLED,
            1 => self::IN_OPR,
            2 => self::SCHEDULED_OPR,
            3 => self::PROTECTED,
        };
    }

    /**
     * Get Badge Class from the value
     * @param self $value
     */
    public static function badgeClass(self $value): string
    {
        return match ($value) {
            self::ENROLLED => 'badge-warning',
            self::IN_OPR => 'badge-primary',
            self::SCHEDULED_OPR => 'badge-success',
            self::PROTECTED => 'badge-danger',
        };
    }

    /**
     * Get an associative array of all statuses
     */
    public static function getStatus(): array
    {
        return [
            self::ENROLLED->value => 0,
            self::IN_OPR->value => 1,
            self::SCHEDULED_OPR->value => 2,
            self::PROTECTED->value => 3,
        ];
    }
}
