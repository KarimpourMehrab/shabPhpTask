<?php

namespace App\Jobs\Product;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFromElasticJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param Product $product
     */
    public function __construct(public Product $product)
    {
        $this->onQueue('UpdateFromElasticJob');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $searchService = $this->product->searchService();
        $searchService->index($this->product->toArray());
    }
}
