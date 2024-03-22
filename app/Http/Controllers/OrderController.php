<?php

namespace App\Http\Controllers;
use App\Customs\Services\OrderService;
use App\Http\Requests\OrderRequest;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    //
    public function index()
    {
        $orders = $this->orderService->getAllOrders();

        if (is_string($orders)) {
            return response()->json($orders, 404);
        }

        return response()->json($orders, 200);
    }

public function show($id)
{
    $order = Order::with('user')->find($id);

    if (!$order) {
        return response()->json('Order not found', 404);
    }

    return response()->json($order, 200);
}
public function store(OrderRequest $request)
{
    return response()->json($this->orderService->storeOrder($request), 201);
}

public function get_order_items($id)
{
    $orderItems = $this->orderService->getOrderItems($id);

    if (is_string($orderItems)) {
        return response()->json($orderItems, 404);
    }

    return response()->json($orderItems, 200);
}



public function get_user_orders($id)
{
    $orders = $this->orderService->getUserOrders($id);

    if (is_string($orders)) {
        return response()->json($orders, 404);
    }

    return response()->json($orders, 200);
}


public function change_order_status($id, Request $request)
{
    return response()->json($this->orderService->updateOrderStatus($id, $request->status), 200);
}

}
