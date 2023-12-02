<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();

        return response()->json($colors, 200);
    }

    public function show($id)
    {
        $color = Color::find($id);

        if (!$color) {
            return response()->json(['message' => 'Color not found'], 404);
        }

        return response()->json(['color' => $color], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $color = Color::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Color created successfully', 'color' => $color], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $color = Color::find($id);

        if (!$color) {
            return response()->json(['message' => 'Color not found'], 404);
        }

        $color->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Color updated successfully', 'color' => $color], 200);
    }

    public function destroy($id)
    {
        $color = Color::find($id);

        if (!$color) {
            return response()->json(['message' => 'Color not found'], 404);
        }

        $color->delete();

        return response()->json(['message' => 'Color deleted successfully'], 200);
    }
}
