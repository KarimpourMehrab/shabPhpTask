<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EventElasticUpdateCommand extends Command
{

    protected $signature = 'product:index';
    protected $description = 'this command indexed all products.';


    public function handle()
    {

        try {
            Product::query()->chunk(100, function ($products) {
                /**
                 * @var Product $product
                 */
                foreach ($products as $product) {
                    $searchService = $product->searchService();
                    if ($searchService->index($product->toArray())) {
                        $this->info($product->id . " indexed!");
                    } else {
                        throw new \Exception();
                    }
                }
            });
            $this->info('all products indexed successfully...');
        } catch (\Exception $e) {
            Log::error($e);
            $this->alert('indexing process in the elastic search failed! please read the laravel.log');
        }
    }
}
