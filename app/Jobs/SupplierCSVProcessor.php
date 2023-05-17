<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SupplierCSVProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $header;

    private $supermarket;

    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $header, $supermarket)
    {
        $this->data = $data;
        $this->supermarket = $supermarket;
        $this->header = $header;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $supplier) {
            try {
                $supplierData = array_combine($this->header, $supplier);
                Supplier::create($supplierData + ['supermarket_id' => $this->supermarket]);

            } catch (\Exception) {
                echo 'Failed';
            }
        }
    }
}
