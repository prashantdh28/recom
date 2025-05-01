<?php

namespace App\Traits;

use App\Models\Account;
use App\Models\ProductList;

trait HandlesMissingRecords
{
    public static function find($id, $columns = ['*'])
    {
        // dd(parent::class);
        $record = ProductList::find($id);

        if (!$record) {
            dd('asda');
            // Handle missing record: Return default data or throw a custom error
            throw new \Exception("Record has been missing", 404);
        }

        return $record;
    }
}
