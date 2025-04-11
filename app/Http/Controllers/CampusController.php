<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Helper\RBAC;
use Illuminate\Support\Facades\Session;

class CampusController extends Controller
{
    public function index()
    {
        if (!session()->has('AuthToken')) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return view('social.unauthorized');
        }

        return view('Campus.index');
    }

    public function getCampusesData(Request $request)
    {
        $columns = ['id', 'name_en', 'name_kh', 'created_by'];
    
        $query = DB::table('campus')->where('status', true);
    
        // Apply search filter
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                  ->orWhere('name_kh', 'like', "%{$search}%")
                  ->orWhere('created_by', 'like', "%{$search}%");
            });
        }
    
        // Total records
        $totalRecords = $query->count();
    
        // Apply pagination
        $limit = $request->input('length');
        $offset = $request->input('start');
        $campuses = $query->skip($offset)->take($limit)->get();
    
        // Prepare response
        $response = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $campuses,
        ];
    
        return response()->json($response);
    }
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
        ]);
        $userID=Session::get('userid');
        $name=Session::get('name');
    
        // Insert the new campus into the database
        DB::insert(
            "INSERT INTO campus (name_en, name_kh, created_by, status, created_at, updated_at) VALUES (?, ?, ?, true, NOW(), NOW())",
            [$request->name_en, $request->name_kh, $userID]
        );
    
        // Return a success response
        return response()->json(['message' => 'Campus created successfully']);
    }

    public function edit($id)
    {
        $campus = DB::selectOne("SELECT * FROM campus WHERE id = ?", [$id]);

        if (!$campus) {
            return response()->json(['message' => 'Campus not found'], 404);
        }

        return response()->json(['campus' => $campus]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
        ]);

        DB::update(
            "UPDATE campus SET name_en = ?, name_kh = ?, updated_at = NOW() WHERE id = ?",
            [$request->name_en, $request->name_kh, $id]
        );

        return response()->json(['message' => 'Campus updated successfully']);
    }

    public function destroy($id)
    {
        DB::update("UPDATE campus SET status = false, updated_at = NOW() WHERE id = ?", [$id]);

        return response()->json(['message' => 'Campus deactivated successfully']);
    }
}