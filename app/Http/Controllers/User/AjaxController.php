<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    // return pizza list
    public function productList(Request $request) {
        // logger($request->status);

        if($request->status === 'asc') {
            $data = Product::orderBy('created_at', 'asc')->get();
        } else if($request->status === 'desc') {
            $data = Product::orderBy('created_at', 'desc')->get();
        }

        return response()->json($data, 200);
    }

    // add to cart function
    public function addToCart(Request $request) {
        // check existing cart
        $cart = Cart::where('user_id', $request->userId)->first();

        if(empty($cart)) {
            // create a new cart
            $cart_id = Cart::create([
                        'user_id' => $request->userId
                    ])->id;
        } else {
            // assiging existing cart id
            $cart_id = $cart->id;
        }

        $cartItem = CartItem::where('cart_id', $cart_id)
                            ->where('product_id', $request->pizzaId)->first();

        if(!empty($cartItem)) {
            $total_qty = $cartItem->total_qty + $request->pizzaCount;
            $total_price = $cartItem->total_price + $request->totalPrice;

            CartItem::where('cart_id', $cart_id)
                            ->where('product_id', $request->pizzaId)
                            ->update(['total_price' => $total_price, 'total_qty' => $total_qty]);
        } else {
            // preparation for cart data
            $data = $this->getCartData($request, $cart_id);

            // add to cart
            CartItem::create($data);
        }


        // response message
        $response = [
            'status' => 'success',
            'message' => 'Add To Cart Complete'
        ];

        // return response in json format
        return response()->json($response, 200);
    }

    // private functions
    // get cart data
    private function getCartData($request, $cart_id) {
        return [
            'cart_id' => $cart_id,
            'product_id' => $request->pizzaId,
            'total_price' => $request->totalPrice,
            'total_qty' => $request->pizzaCount
        ];
    }
}
