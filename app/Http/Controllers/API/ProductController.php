<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::all();
    return response()->json(['data' => $products], 200);
}



    public function show($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json(['data' => $product], 200);
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $productData = $request->all();

    // Process image if provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName); // Save to storage/images directory
        $productData['image'] = asset("storage/images/{$imageName}");
    }

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
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    $validator = Validator::make($request->all(), [
        'title' => 'string',
        'barcode' => 'string',
        'qty' => 'nullable|integer',
        'unit_name' => 'nullable|string',
        'color_name' => 'nullable|string',
        'size' => 'nullable|string',
        'type' => 'nullable|string',
        'price' => 'numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $productData = $request->all();

    // Process image if provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName); // Save to storage/images directory
        $productData['image'] = asset("storage/images/{$imageName}");
    }

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





    public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    // Delete associated image file if it exists
    if ($product->image) {
        Storage::delete('public/images/' . $product->image);
    }

    $product->delete();

    return response()->json(['message' => 'Product deleted successfully'], 200);
}
}
