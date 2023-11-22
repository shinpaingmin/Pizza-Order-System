<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // direct to order list page
    public function list() {
        $orders = Order::select('orders.*', 'users.username', 'order_items.total_price', 'order_items.total_qty', 'products.*')
                ->join('order_items', 'orders.id', 'order_items.order_id')
                ->join('products', 'order_items.product_id', 'products.id')
                ->join('users', 'orders.user_id', 'users.id')
                ->orderBy('order_items.created_at', 'desc')
                ->paginate(5);

        // dd($orders->toArray());

        return view('admin.order.list', compact('orders'));
    }

    // order status sorting with ajax
    public function ajaxStatus(Request $request) {
        $orders = Order::select('orders.*', 'users.username', 'order_items.total_price', 'order_items.total_qty', 'products.*')
            ->join('order_items', 'orders.id', 'order_items.order_id')
            ->join('products', 'order_items.product_id', 'products.id')
            ->join('users', 'orders.user_id', 'users.id')
            ->orderBy('order_items.created_at', 'desc');
        if(is_null($request->status)) {
            $orders = $orders->get();
        } else {
            $orders = $orders->where('status', $request->status)->get();
        }
        logger($orders);
    }
}
