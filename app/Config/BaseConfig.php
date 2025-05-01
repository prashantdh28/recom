<?php

namespace App\Config;

class BaseConfig
{
    /** This is for Parent Title in All Page Breadcrumd Title */
    protected static string $parentTitle = 'Transparency Management' ;
    /** This is for Listing Page Breadcrumd Title */
    protected static string $listBreadCrumbs = 'Listing';
    /** This is for Create Page Breadcrumd Title */
    protected static string $createBreadCrumbs = 'Create';
    /** This is for Edit Page Breadcrumd Title */
    protected static string $editBreadCrumbs = 'Edit';

    public static function getListBreadCrumbs() : array
    {
        return ['name' => self::$listBreadCrumbs];
    }

    public static function getCreateBreadCrumbs()  : array
    {
        return ['name' => self::$createBreadCrumbs];
    }

    public static function getEditBreadCrumbs()  : array
    {
        return ['name' => self::$editBreadCrumbs];
    }
}