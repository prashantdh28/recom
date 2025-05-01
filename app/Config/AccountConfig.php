<?php

namespace App\Config;

class AccountConfig extends BaseConfig
{
    /** Child Title is the next Title of Parent Title in Breadcrumbs */
    private static array $childTitle;

    /** Set & Get the Child Title */
    private static function getChildTitle(): array
    {
        if (!isset(self::$childTitle)) {
            self::$childTitle = ['name' => 'Account Config', 'url' => route('account-config.index')];
        }
        return self::$childTitle;
    }

    /** 
     * Generate Breadcrumbs for particular page 
     * @param string $type
    */
    public static function generateBreadcrumbs(string $type = 'list') : array
    {
        return [
                self::$parentTitle,
                self::getChildTitle(),
                ($type == 'create') ? self::getCreateBreadCrumbs() : ($type == 'edit' ? self::getEditBreadCrumbs() : self::getListBreadCrumbs())
            ];
    }
}