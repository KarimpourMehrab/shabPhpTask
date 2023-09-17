<?php

namespace App\Http\Controllers;

use App\Exceptions\General\NotFoundException;
use App\Exceptions\Order\CartItemIsEmptyException;
use App\Http\Requests\Product\DeleteRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * @throws CartItemIsEmptyException
     */
    public function store(): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = User::with('cartItems.product')->where('id', auth()->id())->first();
        if ($user->cartItems()->count() < 1) {
            throw  new CartItemIsEmptyException();
        }
        $this->data = $this->makeOrder($user, $user->cartItems);
        $this->cleanBasket($user);
        return $this->response(Response::HTTP_CREATED);
    }

    private function makeOrder(User $user, $cartItem): Model|Builder
    {
        $delivery = request()->input('delivery');
        $order = Order::query()->create([
            'user_id' => $user->id,
            'final_price' => $this->getFinalPrice($user)
        ]);
        $orderItems = [];
        foreach ($cartItem as $item) {
            $orderItems[] = [
                'price' => $delivery ? $item->product->price : $item->product->price + $item->product->delivery,
                'order_id' => $order->id,
                'product_id' => $item->product->id
            ];
        }
        OrderItem::query()->insert($orderItems);
        $order->load('items.product');
        return $order;
    }

    private function getFinalPrice(User $user)
    {
        $delivery = request()->input('delivery');
        $finalPrice = 0;
        foreach ($user->cartItems as $cartItem) {
            $finalPrice += $delivery ? $cartItem->product->price : $cartItem->product->price + $cartItem->product->delivery;
        }
        return $finalPrice;
    }

    public function cleanBasket(User $user)
    {
        $user->cartItems()->delete();
    }

    public function delete(string $id): JsonResponse
    {
        $this->data[] = CartItem::where('id', $id)->delete();
        return $this->response(Response::HTTP_CREATED);
    }


}
