<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItems;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $items =  Order::with('user')->all();

        return view('admin.order.index',compact('items'));
    }

    public function show($order_id)
    {
        $order = Order::where('order_no',$order_id)->with('orderItems')->first();
        return view('admin.order.show',compact('order'));
    }

    public function changeStatus(Request $request,$order_id)
    {
        $order = Order::where('order_no',$order_id)->first();
        $order->status = 'ship_done';
        $order->save();

        return redirect()->back();
    }

    public function select($status)
    {
        $items = Order::where('status',$status)->get();
        return view('admin.order.index',compact('items'));
    }

    public function destroy(Request $request,$order_id)
    {
        $order = Order::where('order_no',$order_id)->first();

        $order_items = OrderItems::where('order_id',$order->id)->get();
        foreach($order_items as $item){
            $item->delete();
        }

        $order->delete();

        return redirect()->back();
    }
}
