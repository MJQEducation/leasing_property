<?php

namespace App\Http\Controllers;

use App\Helper\RBAC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Abbreviation;

class AbbreviationController extends Controller
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

        return view('abbreviation.index');
    }
    public function data()
    {
        if (!session()->has('AuthToken')) {
            return redirect('login');
        }
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return view('social.unauthorized');
        }

        $abbreviations = Abbreviation::where('status', true)->get();

        return response()->json(['abbreviations' => $abbreviations], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('abbreviation.form');
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
            'store_code' => 'required',
            'name' => 'required',
            'substore' => 'required'
        ]);


        $abbreviation = Abbreviation::create([
            'abbreviation' => $validated['abbreviation'],
            'is_sub' => $validated['substore'],
            'store_code' => $request->input('store_code'),
            'status' => true,
            'created_by'=>1,
            'name'=>$validated['name']
        ]);

        return response()->json([
            'message' => 'abbreviation added successfully.',
            'abbreviation' => $abbreviation,
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
        $abbreviation = Abbreviation::find($id);

        // Return error if not found
        if (!$abbreviation) {
            return response()->json(['message' => 'abbreviation not found.'], 404);
        }

        // Return customer details
        return response()->json(['abbreviation' => $abbreviation], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        // Find the abbreviation by ID
        $abbreviation = Abbreviation::find($id);
        
        // Return error if not found
        if (!$abbreviation) {
            return response()->json(['message' => 'Abbreviation not found.'], 404);
        }

        // Return abbreviation details for editing
        return response()->json(['abbreviation' => $abbreviation], 200);
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
        $Abbreviation = Abbreviation::find($id);
        if (!$Abbreviation) {
            return response()->json(['message' => 'Abbreviation not found.'], 404);
        }
    
        // Update Abbreviation details
        $Abbreviation->update([
            'abbreviation' => $Abbreviation->abbreviation,
            'is_sub' => $request->input('is_sub'),
            'store_code' => $request->input('store_code'),
            'status' => true,
            'created_by' => 1, // Adjust based on your user logic
            'name' => $request->input('name'),
        ]);
    
        // Return success response
        return response()->json([
            'message' => 'Abbreviation updated successfully.',
            'abbreviation' => $Abbreviation,
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
        $abbreviation = Abbreviation::find($id);

        // Return error if not found
        if (!$abbreviation) {
            return response()->json(['message' => 'Abbreviation not found.'], 404);
        }

        try {
            // Soft delete (deactivate) the abbreviation
            $abbreviation->update(['status' => false]);

            // Return success response
            return response()->json(['message' => 'Abbreviation deactivated successfully.'], 200);
        } catch (\Exception $e) {
            // Return error response on failure
            return response()->json(['message' => 'Failed to deactivate customer.'], 500);
        }
    }
}