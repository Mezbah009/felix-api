<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return response()->json($customers, 200);
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json(['customer' => $customer], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|unique:customers',
            'email' => 'nullable|email|unique:customers',
            'name' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $customer = Customer::create($request->all());

        return response()->json(['message' => 'Customer created successfully', 'customer' => $customer], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => [
                'required',
                Rule::unique('customers')->ignore($id),
            ],
            'email' => 'nullable|email|unique:customers,email,' . $id,
            'name' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->update($request->all());

        return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer], 200);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully'], 200);
    }






    //search
    public function searchByMobile(Request $request)
{
    $validator = Validator::make($request->all(), [
        'mobile' => 'required|exists:customers,mobile',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $customer = Customer::where('mobile', $request->input('mobile'))->first();

    return response()->json(['customer' => $customer], 200);
}
}
