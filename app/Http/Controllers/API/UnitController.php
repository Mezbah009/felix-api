<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();

        return response()->json($units, 200);
    }

    public function show($id)
    {
        $unit = Unit::find($id);

        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }

        return response()->json(['unit' => $unit], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nameBn' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $unit = Unit::create([
            'name' => $request->input('name'),
            'nameBn' => $request->input('nameBn'),
        ]);

        return response()->json(['message' => 'Unit created successfully', 'unit' => $unit], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nameBn' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $unit = Unit::find($id);

        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }

        $unit->update([
            'name' => $request->input('name'),
            'nameBn' => $request->input('nameBn'),
        ]);

        return response()->json(['message' => 'Unit updated successfully', 'unit' => $unit], 200);
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);

        if (!$unit) {
            return response()->json(['message' => 'Unit not found'], 404);
        }

        $unit->delete();

        return response()->json(['message' => 'Unit deleted successfully'], 200);
    }
}
