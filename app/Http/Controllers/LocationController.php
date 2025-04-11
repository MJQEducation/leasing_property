<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Helper\RBAC;

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

    public function getLocationsData()
    {
        $locations = DB::select("SELECT * FROM location WHERE status = true");
        return response()->json(['locations' => $locations]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required',
            'name_kh' => 'required',
        ]);

        DB::insert(
            "INSERT INTO location (name_en, name_kh, created_by, status, created_at, updated_at) VALUES (?, ?, ?, 1, NOW(), NOW())",
            [$request->name_en, $request->name_kh, Auth::id()]
        );

        return response()->json(['message' => 'Location created successfully']);
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
