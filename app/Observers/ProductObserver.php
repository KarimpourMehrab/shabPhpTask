<?php

namespace App\Observers;

use App\Jobs\Product\RemoveFromElasticJob;
use App\Jobs\Product\UpdateFromElasticJob;
use App\Models\Product;

class ProductObserver
{

    public function created(Product $product): void
    {
        UpdateFromElasticJob::dispatch($product);
    }


    public function deleted(Product $product): void
    {
        RemoveFromElasticJob::dispatch($product);
    }
}
