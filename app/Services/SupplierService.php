<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\SupplierCSVProcessor;

class SupplierService
{
    public function upload_csv(array $supperMarket, $request)
    {

        $csv = file($request->supplier_file);
        $chunks = array_chunk($csv, 1000);
        $header = [];

        foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);
            if ($key == 0) {
                $header = $data[0];
                unset($data[0]);
            }

            SupplierCSVProcessor::dispatch($data, $header, $supperMarket['supermarket_id']);

        }

    }
}
