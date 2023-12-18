<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();

        return response()->json(['data' => $orders], 200);
    }

    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['data' => $order], 200);
    }

    public function store(Request $request)
    {
        $validator = $this->validateOrderRequest($request);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $data = $validator->validated();
        $order_amount = 0;
        foreach ($data['order_items'] as $item) {
            $product = Product::find($item['product_id']);
            $order_amount = $order_amount + $product['price'] * $item['quantity'];
        }
        if (isset($data['shipping_charge']))
            $total_amount = $order_amount + $data['shipping_charge'];
        else
            $total_amount = $order_amount;

        $data['total_price'] = $total_amount;
        $data['order_amount'] = $order_amount;
        $order = Order::create($data);
        foreach ($data['order_items'] as $item) {
            $product = Product::find($item['product_id']);
            $orderItem = new OrderItem();
            $orderItem->product_id = $product['id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $product['price'];
            $order->orderItems()->save($orderItem);
        }
      
        return response()->json(['message' => 'Order created successfully', 'data' => $order], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateOrderRequest($request, $id);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->update($request->all());

        return response()->json(['message' => 'Order updated successfully', 'data' => $order], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }

    protected function validateOrderRequest(Request $request, $orderId = null)
    {
        $rules = [
            // Add your validation rules here based on your requirements
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string',
            'customer_mobile' => 'nullable|string',
            'customer_address' => 'nullable|string',
            'shipping_charge' => 'nullable|numeric',
            'total_price' => 'nullable|numeric',
            'order_amount' => 'nullable|numeric',
            'payment_status' => 'required|in:Paid,Unpaid',
            'current_status' => 'required|in:Pending,Packing,Delivery,Delivered,Canceled',
            'pay_now_qr' => 'nullable|string',
            'customer_sms' => 'nullable|string',
            'rider_sms' => 'nullable|string',
            'order_items' => 'required|array',
        ];

        if ($orderId) {
            $rules['customer_id'] .= ',' . $orderId;
        }

        return Validator::make($request->all(), $rules);
    }

    // ... (other methods)

    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'payment_status' => 'required|in:Paid,Unpaid',
        ]);

        $order->update($validatedData);

        return response()->json(['data' => $order]);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'current_status' => 'required|in:Pending,Packing,Delivery,Delivered,Canceled',
        ]);

        $order->update($validatedData);

        return response()->json(['data' => $order]);
    }


    // ... (other methods)

    public function getOrderHistoryByDate(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getOrderHistoryValidationRules());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');

        $query = Order::whereYear('created_at', $year);

        if (!is_null($month)) {
            $query->whereMonth('created_at', $month);
        }

        if (!is_null($day)) {
            $query->whereDay('created_at', $day);
        }

        $orders = $query->get();

        // Calculate total quantity, total price, and total orders
        $totalQuantity = $orders->sum('quantity');
        $totalPrice = $orders->sum('total_price');
        $totalOrders = $orders->count();

        return response()->json([
            'data' => $orders,
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice,
            'total_orders' => $totalOrders,
        ]);
    }

    protected function getOrderHistoryValidationRules()
    {
        return [
            'year' => 'required|integer|min:1900',
            'month' => 'nullable|integer|between:1,12',
            'day' => 'nullable|integer|between:1,31',
        ];
    }
}
