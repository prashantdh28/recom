<?php

namespace App\Services;

use App\Enums\ProductFileEnum;
use App\Models\Account;
use App\Models\TransparencyProductFile;
use Illuminate\Support\Facades\Storage;

class ProductFileService
{
    /**
     * Get List of Account/Business Name.
     */
    public function getAccounts()
    {
        return Account::orderBy('id', 'desc')->get(['id', 'name']);
    }

    public function getFile()
    {
        return TransparencyProductFile::whereProcessingStatus(ProductFileEnum::getStatus(ProductFileEnum::PENDING))->select('id', 'file_name', 'account_config_id')->orderBy('id', 'asc')->first();
    }

    public function getProductFilePath($fileName)
    {
        return $fileName ? Storage::disk('public')->url("transparency/product-files/$fileName") : null;
    }
}
