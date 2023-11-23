<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // direct to order list page
    public function list() {
        $orders = Order::when(request('searchKey'), function($query) {
                    $query->where('orders.order_code', 'like', '%' . request('searchKey') . '%');
                })
                ->select('orders.*', 'users.username')
                ->join('users', 'orders.user_id', 'users.id')
                ->orderBy('orders.created_at', 'desc')
                ->paginate(5);

        // dd($orders->toArray());

        return view('admin.order.list', compact('orders'));
    }

    // order status sorting with ajax
    public function ajaxStatus(Request $request) {
        $orders = Order::select('orders.*', 'users.username')
            ->join('users', 'orders.user_id', 'users.id')
            ->orderBy('orders.created_at', 'desc');

        if(is_null($request->status)) {
            $orders = $orders->get();
        } else {
            $orders = $orders->where('status', $request->status)->get();
        }

        $response = [
            'status' => '200',
            'message' => 'Success',
            'data' => $orders
        ];

        return response()->json($response, 200);
    }

    // ajax change status
    public function ajaxChangeStatus(Request $request) {
        Order::where('id', $request->orderId)->update(['status' => $request->status]);

        $response = [
            'status' => '200',
            'message' => 'Success',
        ];

        return response()->json($response, 200);
    }

    // direct order list info page
    public function listInfo($id) {
        $orders = OrderItem::select('order_items.*', 'products.product_name', 'products.image')
                            ->join('products', 'order_items.product_id', 'products.id')
                            ->where('order_items.order_id', $id)
                            ->get();

        $orderInfo = Order::select('orders.*', 'users.username')
                        ->join('users', 'orders.user_id', 'users.id')
                        ->where('orders.id', $id)
                        ->first();

        $total = 3000; // delivery fee
        foreach ($orders as $order) {
            $total += $order->total_price;
        }

        return view('admin.order.productList', compact('orders', 'orderInfo', 'total'));
    }
}
