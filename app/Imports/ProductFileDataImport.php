<?php

namespace App\Imports;

use App\Models\ProductList;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Importer;
use Throwable;

class ProductFileDataImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts
{
    use Importable;

    public $errorRows = [];
    public $accountConfigId = null;
    public $productFileId = null;

    public function __construct($accountConfigId, $productFileId)
    {
        $this->accountConfigId = $accountConfigId;
        $this->productFileId = $productFileId;
    }

    public function model(array $row)
    {
        if(!$this->productFileId)
        {
            throw new \Exception("Product File Id is missing", 500);
        }

        if (empty($row['sku'])) {
            // Capture error row with an error message
            $row['error_log'] = 'SKU is required and cannot be null';
            $this->errorRows[] = $row;
            return null; // Skip database insertion
        }

        if (empty($row['gtin'])) {
            // Capture error row with an error message
            $row['error_log'] = 'GTIN is required and cannot be null';
            $this->errorRows[] = $row;
            return null; // Skip database insertion
        }

        return new ProductList([
            'account_config_id' => $this->accountConfigId,
            'product_file_id' => $this->productFileId,
            'brand' => $row['brand'],
            'product_name' => $row['product_name'],
            'product_status' => $row['product_status'],
            'gtin' => $row['gtin'],
            'sku' => $row['sku'],
            'asin' => $row['asin'],
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function uniqueBy()
    {
        return 'sku';
    }
}
