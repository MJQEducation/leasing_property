<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Helper\RBAC;

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

    public function getCampusesData()
    {
        $campuses = DB::select("SELECT * FROM campus WHERE status = true");
        return response()->json(['campuses' => $campuses]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required',
            'name_kh' => 'required',
        ]);

        DB::insert(
            "INSERT INTO campus (name_en, name_kh, created_by, status, created_at, updated_at) VALUES (?, ?, ?, 1, NOW(), NOW())",
            [$request->name_en, $request->name_kh, Auth::id()]
        );

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
            'name_en' => 'required',
            'name_kh' => 'required',
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
