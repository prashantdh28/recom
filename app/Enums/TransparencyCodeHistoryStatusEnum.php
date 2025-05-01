<?php

namespace App\Enums;

enum TransparencyCodeHistoryStatusEnum : string
{
    case PENDING = 'Pending';
    case IN_PROGRESS = 'In Progress';
    case SUCCESS = 'Success';
    case ERROR = 'Error';
    
    /**
     * GET Badge Name from the value
     * @param int $value
     */
    public static function fromInt(int $value): ?self
    {
        return match ($value) {
            0 => self::PENDING,
            1 => self::IN_PROGRESS,
            2 => self::SUCCESS,
            3 => self::ERROR,
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
            self::IN_PROGRESS => 'badge-primary',
            self::SUCCESS => 'badge-success',
            self::ERROR => 'badge-danger',
        };
    }

    /**
     * Get an associative array of all statuses
     */
    public static function getStatus(): array
    {
        return [
            self::PENDING->value => 0,
            self::IN_PROGRESS->value => 1,
            self::SUCCESS->value => 2,
            self::ERROR->value => 3,
        ];
    }

    /**
     * GET Value from the Status
     * @param string $status
     */
    public static function getIntegerValue(self $status): ?int
    {
        return match ($status) {
            self::PENDING => 0,
            self::IN_PROGRESS => 1,
            self::SUCCESS => 2,
            self::ERROR => 3,
        };
    }
}
