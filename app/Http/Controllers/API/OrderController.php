<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    // public function index()
    // {
    //     $orders = Order::all();

    //     return response()->json(['data' => $orders], 200);
    // }
    public function index()
{
    $orders = Order::all();

    $formattedOrders = $orders->map(function ($order) {
        return [
            'order' => $order,
            'invoice_id' => $order->invoice_id,
            'total_quantity' => $order->orderItems->sum('quantity'),
            'total_amount' => $order->total_price,
            // Add other fields as needed
        ];
    });

    return response()->json(['data' => $formattedOrders]);
}

    public function show($id)
    {
        $order = Order::with('orderItems')->find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'data' => [
                'order' => $order,
                'invoice_id' => $order->invoice_id,
                'total_quantity' => $order->orderItems->sum('quantity'),
                'total_amount' => $order->total_price,
            ],
        ]);
    }




    public function store(Request $request)
{
    $validator = $this->validateOrderRequest($request);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $data = $validator->validated();
    $orderAmount = 0;

    foreach ($data['order_items'] as $item) {
        $product = Product::find($item['product_id']);

        $orderAmount += $product['price'] * $item['quantity'];

        // Check if there is enough stock before creating the order
        if ($product['qty'] < $item['quantity']) {
            return response()->json(['error' => 'Not enough stock for product ' . $product['name']], 400);
        }

        // Decrease the stock quantity
        $product->qty -= $item['quantity'];
        $product->save();
    }

    if (isset($data['shipping_charge'])) {
        $totalAmount = $orderAmount + $data['shipping_charge'];
    } else {
        $totalAmount = $orderAmount;
    }

    // Generate a unique invoice ID
    $invoiceId = substr(str_replace('-', '', Str::uuid()->toString()), 0, 12);


    $data['invoice_id'] = $invoiceId;
    $data['total_price'] = $totalAmount;
    $data['order_amount'] = $orderAmount;

    $order = Order::create($data);

    foreach ($data['order_items'] as $item) {
        $product = Product::find($item['product_id']);
        $orderItem = new OrderItem();
        $orderItem->product_id = $product['id'];
        $orderItem->quantity = $item['quantity'];
        $orderItem->price = $product['price'];
        $order->orderItems()->save($orderItem);
    }

    return response()->json([
        'message' => 'Order created successfully',
        'data' => [
            'order' => $order,
            'invoice_id' => $invoiceId,
            'total_quantity' => $order->orderItems->sum('quantity'),
            'total_amount' => $totalAmount,
        ],
    ], 201);
}

public function update(Request $request, $id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    $validator = Validator::make($request->all(), $this->getOrderValidationRules());

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $data = $validator->validated();

    // Remove existing order items
    $order->orderItems()->delete();

    $orderAmount = 0;

    foreach ($data['order_items'] as $item) {
        $product = Product::find($item['product_id']);

        $orderAmount += $product['price'] * $item['quantity'];

        // Check if there is enough stock before updating the order
        if ($product['qty'] < $item['quantity']) {
            return response()->json(['error' => 'Not enough stock for product ' . $product['name']], 400);
        }

        // Decrease the stock quantity
        $product->qty -= $item['quantity'];
        $product->save();

        // Create new order items
        $orderItem = new OrderItem([
            'product_id' => $product['id'],
            'quantity' => $item['quantity'],
            'price' => $product['price'],
        ]);

        $order->orderItems()->save($orderItem);
    }

    // Update order details
    $order->update([
        'customer_id' => $data['customer_id'],
        'customer_name' => $data['customer_name'],
        // Update other fields as needed
        'order_amount' => $orderAmount,
        'total_price' => $orderAmount + $data['shipping_charge'],
    ]);

    return response()->json([
        'message' => 'Order updated successfully',
        'data' => [
            'order' => $order,
            'invoice_id' => $order->invoice_id,
            'total_quantity' => $order->orderItems->sum('quantity'),
            'total_amount' => $order->total_price,
        ],
    ]);
}

public function destroy($id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    // Increase stock quantity for each product in the order
    foreach ($order->orderItems as $orderItem) {
        $product = $orderItem->product;
        $product->qty += $orderItem->quantity;
        $product->save();
    }

    // Delete the order and associated order items
    $order->delete();

    return response()->json(['message' => 'Order deleted successfully']);
}

protected function validateOrderRequest(Request $request, $orderId = null)
{
    $rules = [
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
        'order_items.*.product_id' => 'required|exists:products,id',
        'order_items.*.quantity' => 'required|integer|min:1',
        // Add additional rules for order items as needed
    ];

    if ($orderId) {
        $rules['customer_id'] .= ',' . $orderId;
    }

    return Validator::make($request->all(), $rules);
}

    // ... (other methods)

    public function updatePaymentStatus(Request $request, $id)
{
    try {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'payment_status' => 'required|in:Paid,Unpaid',
        ]);

        $order->update($validatedData);

        return response()->json(['data' => $order]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update payment status'], 500);
    }
}

public function updateStatus(Request $request, $id)
{
    try {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'current_status' => 'required|in:Pending,Packing,Delivery,Delivered,Canceled',
        ]);

        $order->update($validatedData);

        return response()->json(['data' => $order]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update status'], 500);
    }
}


    // ... (other methods)

    public function getOrderHistoryByDate(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getOrderHistoryValidationRules());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
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

        $orders = $query->orderBy('created_at')->get();

        // Calculate total quantity, total price, and total orders
        $totalQuantity = $orders->flatMap(function ($order) {
            return $order->orderItems->pluck('quantity');
        })->sum();

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





    public function getOrderDetails($orderId)
    {
        $order = Order::with('orderItems.product')->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $totalQuantity = $order->orderItems->sum('quantity');
        $totalAmount = $order->total_price;

        return response()->json([
            'invoice' => $order,
            'quantity' => $totalQuantity,
            'amount' => $totalAmount,
        ]);
    }




    // public function getAllOrders()
    // {
    //     $orders = Order::all();

    //     $formattedOrders = $orders->map(function ($order) {
    //         return [
    //             'order' => $order,
    //             'invoice_id' => $order->invoice_id,
    //             'total_quantity' => $order->orderItems->sum('quantity'),
    //             'total_amount' => $order->total_price,
    //             // Add other fields as needed
    //         ];
    //     });

    //     return response()->json(['data' => $formattedOrders]);
    // }


}

