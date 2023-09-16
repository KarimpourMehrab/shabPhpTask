<?php

namespace App\Models\traits\Product;


use Illuminate\Support\Facades\Log;

trait Functions
{
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
