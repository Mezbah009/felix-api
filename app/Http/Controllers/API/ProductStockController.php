<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductStockController extends Controller
{


    public function index()
    {
        // Retrieve all products with their associated product stocks
        $products = Product::with('productStocks')->get();

        // Return a response with the list of products and their associated product stocks
        return response()->json(['products' => $products], 200);
    }


    public function show($id)
    {
        // Find the Product record by its ID along with its associated product stocks
        $product = Product::with('productStocks')->find($id);

        // If the product is not found, return an error response
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Return a response with the Product record and its associated product stocks
        return response()->json(['product' => $product], 200);
    }




    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'action' => 'required|in:increase,decrease',
            'qty' => 'required|integer',
            'stock_date' => 'required|date',
            'purchase_rate' => 'required|string',
            'purchase_no' => 'required|string',
            'sales_invoice_no' => 'required|string',
            'remarks' => 'nullable|string',
            'supplier_name' => 'required|string',
            'chalan_no' => 'required|string',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create a new ProductStock record
        $productStock = ProductStock::create($request->all());

        // Update the product quantity based on the stock action
        $productStock->updateProductQuantity();

        // Return a success response
        return response()->json(['message' => 'Product stock created successfully', 'product_stock' => $productStock], 201);
    }
}
