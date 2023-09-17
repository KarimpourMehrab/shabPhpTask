<?php

namespace App\Models\traits\General;


use App\Services\Search\Elastic\Fast;
use App\Services\Search\DeliveryService;

trait Searchable
{
    /**
     * @var array|string[]
     */
    private static array $searchAbleFields = ['title'];
    private static string $indexName = 'products';

//    public function index(bool $shouldBeSync = false): void
//    {
//        if ($shouldBeSync) {
//            ProductElasticJob::dispatchSync(self::$indexName, $this->id);
//        } else {
//            ProductElasticJob::dispatch(self::$indexName, $this->id);
//        }
//    }

    /**
     * @param string|null $searchService
     * @return mixed
     */
    public static function searchService(string|null $searchService = null): mixed
    {
        $searchService = $searchService ?? Fast::name();
        $searchService = DeliveryService::make($searchService);
        $searchService->setIndex(self::$indexName);
        $searchService->setFields(self::$searchAbleFields);
        return $searchService;
    }


}
