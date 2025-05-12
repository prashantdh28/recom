<?php

namespace App\Jobs;

use App\Enums\ProductFileEnum;
use App\Exports\ErrorProductListExport;
use App\Imports\ProductFileDataImport;
use App\Services\ProductFileService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProcessProductFileImportJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ProductFileService $productFileService): void
    {
        Log::info("Check that queue work command is running or not?");
        return;
        try {
            $productFileService = new ProductFileService();
            $getFile = $productFileService->getFile();
                
            if(!$getFile)
            {
                Log::info("Currently, there is not available any file for import data");
                return;
            }

            $getFilePath = Storage::disk('public')->path("transparency/product-files/$getFile->file_name");

            if(!$getFilePath)
            {
                $getFile->update(['processing_status' => ProductFileEnum::getStatus(ProductFileEnum::FAILED)]);
                return;
            }
            
            $import = new ProductFileDataImport($getFile->account_config_id, $getFile->id);
            $import->import($getFilePath);

            if($import->errorRows)
            {
                $errorFileName = time()."_error.xlsx";
                Excel::store(new ErrorProductListExport($import->errorRows), "transparency/product-files/errors/$errorFileName", 'public');
                $getFile->update([
                    'processing_status' => ProductFileEnum::getStatus(ProductFileEnum::ERROR),
                    'error_file_name' => $errorFileName
                ]);
                return;
            }
            
            $getFile->update(['processing_status' => ProductFileEnum::getStatus(ProductFileEnum::COMPLETE)]);
        } catch (\Exception $e) {
            Log::info("Error From ProcessProductFileImportJob = ".$e->getMessage());
        }
    }
}
