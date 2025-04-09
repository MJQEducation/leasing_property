<?php

namespace App\Http\Controllers;

use App\Helper\RBAC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is authenticated
        if (!session()->has('AuthToken')) {
            return redirect('login');
        }

        // Check RBAC permissions
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return view('social.unauthorized');
        }

        return view('customer.index');
    }
    public function data()
    {
        if (!session()->has('AuthToken')) {
            return redirect('login');
        }
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return view('social.unauthorized');
        }

        $customers = Customer::where('active', true)->get();
        return response()->json(['customers' => $customers], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Check authentication
        if (!session()->has('AuthToken')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Check RBAC permissions
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request data
        $validated = $request->validate([
            'ownerName' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        // Create a new customer
        $customer = Customer::create([
            'ownerName' => $validated['ownerName'],
            'phone' => $validated['phone'],
            'active' => true,
        ]);

        // Return success response
        return response()->json([
            'message' => 'Customer added successfully.',
            'customer' => $customer,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Find the customer by ID
        $customer = Customer::find($id);

        // Return error if not found
        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Return customer details
        return response()->json(['customer' => $customer], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        // Find the customer by ID
        $customer = Customer::find($id);

        // Return error if not found
        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Return customer details for editing
        return response()->json(['customer' => $customer], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
{
    // Find the customer by ID
    $customer = Customer::find($id);

    // Return error if not found
    if (!$customer) {
        return response()->json(['message' => 'Customer not found.'], 404);
    }

    // Update customer details
    $customer->update([
        'ownerName' => $request->input('ownerName'),
        'phone' => $request->input('phone'),
    ]);

    // Return success response
    return response()->json([
        'message' => 'Customer updated successfully.',
        'customer' => $customer,
    ], 200);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        // Find the customer by ID
        $customer = Customer::find($id);

        // Return error if not found
        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        try {
            // Soft delete (deactivate) the customer
            $customer->update(['active' => false]);

            // Return success response
            return response()->json(['message' => 'Customer deactivated successfully.'], 200);
        } catch (\Exception $e) {
            // Return error response on failure
            return response()->json(['message' => 'Failed to deactivate customer.'], 500);
        }
    }
}