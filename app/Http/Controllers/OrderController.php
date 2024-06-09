<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function show($id): JsonResponse
    {
        $order = Order::findOrFail($id);
        return response()->json($order);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'total_price' => 'required|numeric|min:0',
                'status' => 'required|string|in:pending,completed,cancelled',
            ]);

            $order = Order::create($validatedData);
            $customer = Customer::findOrFail($order->customer_id);

            ProcessOrder::dispatch($order, $customer);

            return response()->json($order, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
