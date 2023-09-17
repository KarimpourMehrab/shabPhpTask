<?php

namespace App\Models\traits\Product;


use App\Services\Delivery\DeliveryService;
use App\Services\Delivery\Fast\Fast;
use Illuminate\Support\Facades\Log;

trait Functions
{

    public function getDeliveryAttribute(): int
    {
        $deliveryService = DeliveryService::make(Fast::name());
        return $deliveryService->calculate($this);
    }

    public function uploadFromRequest(mixed $fileFromRequest, string $collection = 'm'): void
    {
        try {
            $this->addMediaFromRequest('image')
                ->setFileName(md5($this->id) . '.' . $fileFromRequest->getClientOriginalExtension())
                ->toMediaCollection($collection);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
