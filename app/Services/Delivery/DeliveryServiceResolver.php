<?php


namespace App\Services\Delivery;


use Exception;
use Illuminate\Support\Str;

class DeliveryServiceResolver
{

    protected $deliveryService;


    /**
     * @throws Exception
     */
    public function __construct(string $deliveryService = null)
    {
        $this->make($deliveryService);
    }

    /**
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        if (in_array(Str::lower($name), $this->getActiveServices())) {
            return $this->make($name);
        }
        return call_user_func_array([$this->deliveryService, $name], $arguments);
    }

    /**
     * @throws Exception
     */
    public function make($deliveryService = null): DeliveryServiceResolver
    {
        # Get default delivery service if the $deliveryService is null
        if (!$deliveryService) $deliveryService = $this->getActiveServices()[0];

        if (!$deliveryService instanceof DeliveryServiceAbstract) {


            if (!in_array($deliveryService, $this->getActiveServices())) {
                throw new Exception('delivery Service Not Found');
            }
            $deliveryService = Str::studly(strtolower($deliveryService));
            $class = 'App\\Services\\Delivery\\' . $deliveryService . '\\' . $deliveryService;
            $deliveryService = new $class();
        }

        $this->deliveryService = $deliveryService;

        return $this;
    }

    private function getActiveServices()
    {
        return config('delivery.active_services');
    }

}
