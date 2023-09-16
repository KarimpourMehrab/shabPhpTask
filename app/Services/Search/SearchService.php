<?php


namespace App\Services\Search;


use Illuminate\Support\Facades\Facade;

class  SearchService extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'searchService';
    }

}
