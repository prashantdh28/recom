<?php

namespace Database\Seeders;

use App\Models\ProductList;
use App\Models\TransparencyGtinCodeHistory;
use Illuminate\Database\Seeder;

class TransparencyGtinCodeHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gtinHistoryRecords = [];
        $getProducts = ProductList::latest()->get(['id', 'gtin', 'sku'])->toArray();

        if(count($getProducts) > 0)
        {
            for ($i=1; $i <= 5; $i++) {
                $randomProductId = array_rand(array_column($getProducts, 'id'), 1);

                while ($randomProductId == 0) {
                    $randomProductId = array_rand(array_column($getProducts, 'id'), 1);
                }

                $index = array_search($randomProductId, array_column($getProducts, 'id'));
                // $labelType = rand(1, 5);
                $labelType = $i;

                $numberOfCodes = rand(1,100);
                $gtinCodes = [];

                for ($j=1; $j <= $numberOfCodes; $j++) {
                    $gtinCodes[] = "AZ:".str()->random(26);
                }

                $gtinHistoryRecords[] = [
                    'transparency_product_id' => $randomProductId,
                    'job_id' => fake()->ean13(),
                    'location' => fake()->uuid(),
                    'number_of_code' => $numberOfCodes,
                    'gtin' => $getProducts[$index]['gtin'] ?? null,
                    'sku' => $getProducts[$index]['sku'] ?? null,
                    'fnsku' => ($labelType == 3 || $labelType == 4) ? fake()->ean13() : null,
                    'label_type' => $labelType,
                    'generated_code' => "[".implode(",",$gtinCodes)."]",
                    'status' => rand(0, 3),
                    'error' => null,
                    'created_by' => 1,
                    'updated_by' => 1
                ];
            }
            // dd($gtinHistoryRecords);
            TransparencyGtinCodeHistory::insert($gtinHistoryRecords);
        }
    }
}
