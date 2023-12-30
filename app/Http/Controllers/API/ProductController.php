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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $productData = $request->except('image');

    // Process image if provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/images'), $imageName);
        $productData['image'] = "storage/images/{$imageName}";
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
    $validator = Validator::make($request->all(), [
        'title' => 'sometimes|required|string',
        'barcode' => 'sometimes|required|string',
        'qty' => 'sometimes|nullable|integer',
        'unit_name' => 'sometimes|nullable|string',
        'color_name' => 'sometimes|nullable|string',
        'size' => 'sometimes|nullable|string',
        'type' => 'sometimes|nullable|string',
        'price' => 'sometimes|required|numeric',
        'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $product = Product::findOrFail($id);

    $productData = $request->except(['image', 'unit_name', 'color_name']);

    // Process image if provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/images'), $imageName);
        $productData['image'] = "storage/images/{$imageName}";
    }

    // Find or create unit based on the provided name
    $unitName = $request->input('unit_name');
    $unit = $unitName ? Unit::firstOrCreate(['name' => $unitName]) : null;

    // Find or create color based on the provided name
    $colorName = $request->input('color_name');
    $color = $colorName ? Color::firstOrCreate(['name' => $colorName]) : null;

    // Check if $unit and $color are not null before associating with the product
    if ($unit && $color) {
        // Associate unit and color with the product
        $productData['unit_id'] = $unit->id;
        $productData['color_id'] = $color->id;
    } else {
        // Handle the case where either $unit or $color is null
        $errorMessage = '';

        if (!$unit) {
            $errorMessage .= 'Unit not found. ';
        } else {
            $errorMessage .= 'Unit ID: ' . $unit->id . '. ';
        }

        if (!$color) {
            $errorMessage .= 'Color not found.';
        } else {
            $errorMessage .= 'Color ID: ' . $color->id . '.';
        }

        return response()->json(['error' => $errorMessage], 404);
    }

    // Update product data
    $product->update($productData);

    return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
}




public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Delete the associated image if it exists
    if (!empty($product->image)) {
        $imagePath = public_path($product->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete the product
    $product->delete();

    return response()->json(['message' => 'Product deleted successfully'], 200);
}

}
