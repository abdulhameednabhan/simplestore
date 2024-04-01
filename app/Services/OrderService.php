<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItems;

use Illuminate\Support\Facades\Auth;

class OrderService
{

    public static function getAllOrders()
    {
        $orders = Order::with('user')->paginate(20);

        if ($orders->isEmpty()) {
            return 'There are no orders';
        }

        foreach ($orders as $order) {
            foreach ($order->items as $orderItem) {
                $product = Product::where('id', $orderItem->product_id)->pluck('name')->first();
                $orderItem->product_name = $product;
            }
        }

        return $orders;
    }


    public static function storeOrder($request)
    {
        $location = Location::where('user_id', Auth::id())->first();

        $request->validated();

        $order = new Order();
        $order->user_id = Auth::id();
        $order->location_id = $location->id;
        $order->total_price = $request->total_price;
        $order->date_of_delivery = $request->date_of_delivery;
        $order->save();

        foreach ($request->order_items as $orderItemData) {
            $this->storeOrderItem($order, $orderItemData);
            $this->updateProductQuantity($orderItemData);
        }

        return 'Order has been added';
    }

    public static function getUserOrders($id)
    {
        $orders = Order::with('items')->where('user_id', $id)->get();

        if ($orders->isEmpty()) {
            return 'No orders found for this user';
        }

        foreach ($orders as $order) {
            self::setProductNames($order);
        }

        return $orders;
    }

    public static function updateOrderStatus($id, $status)
    {
        $order = Order::find($id);

        if ($order) {
            $order->update(['status' => $status]);
            return 'Status changed successfully';
        } else {
            return 'Order was not found';
        }
    }

    private  function storeOrderItem($order, $orderItemData)
    {
        $orderItem = new OrderItems();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $orderItemData['product_id'];
        $orderItem->quantity = $orderItemData['quantity'];
        $orderItem->price = Product::find($orderItemData['product_id'])->price;
        $orderItem->save();
    }

    private function updateProductQuantity($orderItemData)
    {
        $product = Product::find($orderItemData['product_id']);
        $product->amount -= $orderItemData['quantity'];
        $product->save();
    }

    private static function setProductNames($order)
    {
        foreach ($order->items as $orderItem) {
            $product = Product::where('id', $orderItem->product_id)->pluck('name')->first();
            $orderItem->product_name = $product;
        }
    }





    public static function getOrderItems($id)
    {
        $orderItems = OrderItems::where('order_id', $id)->get();

        if ($orderItems->isEmpty()) {
            return 'No items found';
        }

        foreach ($orderItems as $orderItem) {
            $product = Product::where('id', $orderItem->product_id)->pluck('name')->first();
            $orderItem->product_name = $product;
        }

        return $orderItems;
    }



    
}
