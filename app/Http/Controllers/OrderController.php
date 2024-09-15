<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\ListPendingOrdersRequest;
use App\Http\Requests\FollowOrderRequest;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(CreateOrderRequest $request)
    {
        $user = Auth::user();
        $numberOfFollowers = $request->input('number_of_followers');
        $result = $this->orderService->createOrder($user, $numberOfFollowers);

        return response()->json($result);
    }

    public function listPendingOrders(ListPendingOrdersRequest $request)
    {
        $user = Auth::user();
        $orders = $this->orderService->listPendingOrders($user,perPage: $request['perPage'],page: $request['page']);

        return response()->json(['status' => true, 'orders' => $orders]);
    }

    public function followOrder(FollowOrderRequest $request)
    {
        $user = Auth::user();
        $orderId = $request->input('order_id');
        $result = $this->orderService->followOrder($user, $orderId);

        return response()->json($result);
    }
}

