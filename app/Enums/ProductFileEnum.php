<?php

namespace App\Enums;

enum ProductFileEnum : string
{
    case PENDING = 'Pending';
    case IN_PROCESS = 'In Process';
    case COMPLETE = 'Completed';
    case ERROR = 'Error';
    case FAILED = 'Failed';
    
    /**
     * GET Status from the value
     * @param int $value
     */
    public static function fromInt(int $value): ?self
    {
        return match ($value) {
            0 => self::PENDING,
            1 => self::IN_PROCESS,
            2 => self::COMPLETE,
            3 => self::ERROR,
            4 => self::FAILED,
        };
    }

    /**
     * Get Badge Class from the value
     * @param self $value
     */
    public static function badgeClass(self $value): string
    {
        return match ($value) {
            self::PENDING => 'badge-warning',
            self::IN_PROCESS => 'badge-warning',
            self::COMPLETE => 'badge-success',
            self::ERROR => 'badge-danger',
            self::FAILED => 'badge-danger',
        };
    }

    /**
     * GET Value from the Status
     * @param string $status
     */
    public static function getStatus(self $status): ?int
    {
        return match ($status) {
            self::PENDING => 0,
            self::IN_PROCESS => 1,
            self::COMPLETE => 2,
            self::ERROR => 3,
            self::FAILED => 4,
        };
    }

    /**
     * GET Value from the Status
     * @param string $status
     */
    public static function getAllStatus(): array
    {
        return [
            self::PENDING->value => 0,
            self::IN_PROCESS->value => 1,
            self::COMPLETE->value => 2,
            self::ERROR->value => 3,
            self::FAILED->value => 4,
        ];
    }
}
