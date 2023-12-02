<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products, 200);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product], 200);
    }




    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'barcode' => 'required|string',
        'qty' => 'nullable|integer',
        'unit_name' => 'nullable|string',
        'color_name' => 'nullable|string',
        'size' => 'nullable|string',
        'type' => 'nullable|string',
        'price' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $productData = $request->all();

    // Find or create unit based on the provided name
    $unit = Unit::firstOrCreate(['name' => $request->input('unit_name')]);

    // Find or create color based on the provided name
    $color = Color::firstOrCreate(['name' => $request->input('color_name')]);

    // Associate unit and color with the product
    $productData['unit_id'] = $unit->id;
    $productData['color_id'] = $color->id;

    $product = Product::create($productData);

    return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
}

public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'barcode' => 'required|string',
        'qty' => 'nullable|integer',
        'unit_name' => 'nullable|string',
        'color_name' => 'nullable|string',
        'size' => 'nullable|string',
        'type' => 'nullable|string',
        'price' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    $productData = $request->all();

    // Find or create unit based on the provided name
    $unit = Unit::firstOrCreate(['name' => $request->input('unit_name')]);

    // Find or create color based on the provided name
    $color = Color::firstOrCreate(['name' => $request->input('color_name')]);

    // Associate unit and color with the product
    $productData['unit_id'] = $unit->id;
    $productData['color_id'] = $color->id;

    $product->update($productData);

    return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
}





    //delete
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
