<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // return pizza list
    public function productList(Request $request) {


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
                            ->update(['total_price' => $total_price, 'total_qty' => $total_qty, 'updated_at' => Carbon::now()]);
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

    // update cart
    public function updateCart(Request $request) {
        // logger($request->all());

        CartItem::where('cart_id', $request->cartId)
                ->where('product_id', $request->productId)
                ->update([
                    'total_qty' => $request->qty,
                    'total_price' => $request->totalPrice,
                    'updated_at' => Carbon::now()
                ]);

        $response = [
            'status' => 'success',
            'message' => 'Updated Successfully'
        ];

        return response()->json($response, 200);
    }

    // delete item
    public function deleteItem(Request $request) {
        CartItem::where('cart_id', $request->cartId)
                ->where('product_id', $request->productId)
                ->delete();

        $response = [
            'status' => 'success',
            'message' => 'Deleted Successfully'
        ];

        return response()->json($response, 200);
    }

    // order items
    public function order(Request $request) {
        $requestArr = $request->all();

        $order = Order::where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->get();

        if(count($order) > 0) {
            $response = [
                'message' => 'Not available'
            ];

            return response()->json($response, 422);
        }
        else
        {
            // create an order, take order id
        $order_id = Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $requestArr[0]['order_code']
        ])->id;

        foreach ($request->all() as $item) {
            OrderItem::create([
                'order_id' => $order_id,
                'product_id' => $item['product_id'],
                'total_price' => $item['total_price'],
                'total_qty' => $item['total_qty']
            ]);
        }

        // delete cart items and cart

        CartItem::where('cart_id', $requestArr[0]['cart_id'])->delete();

        Cart::where('user_id', Auth::user()->id)->delete();

        $response = [
            'status' => 'success',
            'message' => 'Ordered Successfully'
        ];

        }



        return response()->json($response, 200);
    }

    // increase view count function for pizza
    public function increaseViewCount(Request $request) {
        $pizza = Product::where('id', $request->product_id)->first();

        $viewCount = [
            'view_count' => $pizza->view_count + 1
        ];

        Product::where('id', $request->product_id)->update($viewCount);

        $response = [
            'status' => '200',
        ];

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
