<?php

namespace App\Http\Controllers;

use App\Exceptions\General\NotFoundException;
use App\Http\Requests\Product\DeleteRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class   CartItemController extends Controller
{
    public function store(string $productId): JsonResponse
    {
        $product = Product::query()->where('id', $productId)->firstOr(fn() => throw new NotFoundException());
        $data = ['product_id' => $product->id, 'user_id' => auth()->id()];
        $this->data = CartItem::query()->updateOrCreate($data, $data);
        return $this->response(Response::HTTP_CREATED);
    }

    public function delete(string $id): JsonResponse
    {
        $this->data[] = CartItem::where('id', $id)->delete();
        return $this->response(Response::HTTP_CREATED);
    }


}
