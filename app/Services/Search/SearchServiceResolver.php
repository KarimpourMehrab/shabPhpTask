<?php


namespace App\Services\Search;


use Exception;
use Illuminate\Support\Str;

class SearchServiceResolver
{

    protected $searchService;


    /**
     * @throws Exception
     */
    public function __construct(string $searchService = null)
    {
        $this->make($searchService);
    }

    /**
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        if (in_array(Str::lower($name), $this->getActiveServices())) {
            return $this->make($name);
        }
        return call_user_func_array([$this->searchService, $name], $arguments);
    }

    /**
     * @throws Exception
     */
    public function make($searchService = null): SearchServiceResolver
    {
        # Get default search service if the $searchService is null
        if (!$searchService) $searchService = $this->getActiveServices()[0];

        if (!$searchService instanceof SearchServiceAbstract) {


            if (!in_array($searchService, $this->getActiveServices())) {
                throw new Exception('search Service Not Found');
            }
            $searchService = Str::studly(strtolower($searchService));
            $class = 'App\\Services\\Search\\' . $searchService . '\\' . $searchService;
            $searchService = new $class();
        }

        $this->searchService = $searchService;

        return $this;
    }

    private function getActiveServices()
    {
        return config('search.active_services');
    }

}
