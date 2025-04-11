<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Helper\RBAC;
use Illuminate\Support\Facades\Session;
class LocationController extends Controller
{
    public function index()
    {
        if (!session()->has('AuthToken')) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return view('social.unauthorized');
        }

        return view('Location.index');
    }

    public function getLocationsData(Request $request)
{
    // Columns to query
    $columns = ['id', 'name_en', 'name_kh', 'status'];

    // Base query
    $query = DB::table('location')->where('status', true);

    // Apply search filter
    if ($request->has('search') && !empty($request->input('search')['value'])) {
        $search = $request->input('search')['value'];
        $query->where(function ($q) use ($search) {
            $q->where('name_en', 'like', "%{$search}%")
              ->orWhere('name_kh', 'like', "%{$search}%");
        });
    }

    // Total records (before filtering)
    $totalRecords = $query->count();

    // Apply pagination
    $limit = $request->input('length'); // Number of rows per page
    $offset = $request->input('start'); // Offset for pagination
    $locations = $query->skip($offset)->take($limit)->get();

    // Prepare response
    return response()->json([
        'draw' => intval($request->input('draw')), // Draw counter
        'recordsTotal' => $totalRecords,          // Total records
        'recordsFiltered' => $totalRecords,       // Filtered records
        'data' => $locations                      // Data for the current page
    ], 200, [], JSON_UNESCAPED_UNICODE); // Use JSON_UNESCAPED_UNICODE
}
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required',
            'name_kh' => 'required',
        ]);
    
        $userID=Session::get('userid');
        $name=Session::get('name');

        DB::insert(
            "INSERT INTO location (name_en, name_kh, created_by,status, created_at, updated_at) VALUES (?, ?, ?, true, NOW(), NOW())",
            [$request->name_en, $request->name_kh, $userID]
        );
    
        return response()->json(['message' => 'Location created successfully', 'created_by' => $name]);
    }

    public function edit($id)
    {
        $location = DB::selectOne("SELECT * FROM location WHERE id = ?", [$id]);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        return response()->json(['location' => $location]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required',
            'name_kh' => 'required',
        ]);

        DB::update(
            "UPDATE location SET name_en = ?, name_kh = ?, updated_at = NOW() WHERE id = ?",
            [$request->name_en, $request->name_kh, $id]
        );

        return response()->json(['message' => 'Location updated successfully']);
    }

    public function destroy($id)
    {
        DB::update("UPDATE location SET status = false, updated_at = NOW() WHERE id = ?", [$id]);

        return response()->json(['message' => 'Location deactivated successfully']);
    }
}
