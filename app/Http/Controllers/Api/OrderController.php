<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order\Order;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected OrderService $orderService;

/*************  ✨ Windsurf Command 🌟  *************/
    /**
     * Initialize the OrderController with the OrderService
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
/*******  9ac05fe1-16b2-474c-9139-3ecd66fa4a56  *******/

    /**
     * List all orders
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['items', 'table'])->get();
        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }

    /**
     * Create a new order
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder(
            $request->user_id,
            $request->items,
            $request->table_id // table selection
        );

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'order' => $order
        ]);
    }

    /**
     * Show a single order
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json([
            'success' => true,
            'order' => $order->load(['items', 'table'])
        ]);
    }

    /**
     * Update an existing order
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $updatedOrder = $this->orderService->updateOrder($order, $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'order' => $updatedOrder
        ]);
    }

    /**
     * Delete an order
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }

    /**
     * Update only order status
     */
    public function updateStatus(Order $order, string $status): JsonResponse
    {
        $order->update(['status' => $status]);

        return response()->json([
            'success' => true,
            'message' => "Order status updated to $status",
            'order' => $order->load(['items', 'table'])
        ]);
    }
}
