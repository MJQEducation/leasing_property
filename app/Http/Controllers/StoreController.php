<?php

namespace App\Http\Controllers;

use App\Helper\RBAC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\Substore;

class StoreController extends Controller
{
    public function index()
    {
        if (!session()->has('AuthToken')) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return view('social.unauthorized');
        }

        return view('store.index');
    }

    public function data()
    {
        if (!session()->has('AuthToken')) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return view('social.unauthorized');
        }

        $stores = DB::select('
            SELECT
                stores.id,
                store_code AS store_code,
                a.abbreviation,
                stores.name_kh,
                stores.name_en,
                c.name_en AS campus,
                l.name_en AS location,
                stores.status AS is_store,
                stores.created_at,
                stores.updated_at,
                \'store\' AS type
            FROM stores
            JOIN campus c ON stores.campus_id = c.id
            JOIN location l ON stores.location_id = l.id
            JOIN abbreviations a ON a.id = stores.abbreviation_id::BIGINT
            WHERE stores.status IS TRUE AND l.status IS TRUE AND c.status IS TRUE

            UNION

            SELECT
                substore.id,
                substore_code AS store_code,
                a.abbreviation,
                substore.name_kh,
                substore.name_en,
                c.name_en AS campus,
                l.name_en AS location,
                substore.status AS is_store,
                substore.created_at,
                substore.updated_at,
                \'substore\' AS type
            FROM substore
            JOIN campus c ON substore.campus_id = c.id
            JOIN location l ON substore.location_id = l.id
            JOIN abbreviations a ON a.id = substore.abbreviation_id::BIGINT
            WHERE substore.status IS TRUE AND l.status IS TRUE AND c.status IS TRUE;
        ');

    
 
    $abbreviation=DB::select("SELECT * FROM abbreviations where status IS TRUE");
  
    $location=DB::select('SELECT * FROM location where status is true');

    $campus=DB::select('SELECT * FROM campus where status is true');

        

        return response()->json(['stores' => $stores,'location'=> $location,'campus'=>$campus,'abbreviation'=>$abbreviation], 200);
    }

    public function create()
    {
        return view('store.form');
    }

    public function store(Request $request)
    {
        if (!session()->has('AuthToken')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'store_code' => 'required|string|max:50',
            'name_en' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'abbreviation' => 'nullable|string|max:50',
            'campus' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        $id = DB::table('stores')->insertGetId(array_merge($validated, [
            'status' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]));

        $store = DB::table('stores')->where('id', $id)->first();

        return response()->json([
            'message' => 'Store added successfully.',
            'store' => $store,
        ], 201);
    }

    public function show($id)
    {
        $store = DB::table('Store')->where('id', $id)->first();

        if (!$store) {
            $store = DB::table('substore')->where('id', $id)->first();
            if (!$store) {
                return response()->json(['message' => 'Store not found.'], 404);
            }
        }

        return response()->json(['store' => $store], 200);
    }

    public function edit($id)
{

    $storeType = request()->query('storeType'); 
    if ($storeType === 'store') {
        $store = DB::table('stores')->where('id', $id)->first();
    } else {
        $store = DB::table('substore')->where('id', $id)->first();
    }

    return response()->json(['store' => $store]);
}


    public function update(Request $request, $id)
    {
        $store = DB::table('stores')->where('id', $id);
        $isMain = true;

        if (!$store->exists()) {
            $store = DB::table('substore')->where('id', $id);
            $isMain = false;

            if (!$store->exists()) {
                return response()->json(['message' => 'Store not found.'], 404);
            }
        }

        $validated = $request->validate([
            'store_code' => 'required|string|max:50',
            'name_en' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'abbreviation' => 'nullable|string|max:50',
            'campus' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        $table = $isMain ? 'stores' : 'substore';

        DB::table($table)->where('id', $id)->update(array_merge($validated, [
            'updated_at' => now()
        ]));

        $updatedStore = DB::table($table)->where('id', $id)->first();

        return response()->json([
            'message' => 'Store updated successfully.',
            'store' => $updatedStore,
        ], 200);
    }

    public function destroy($id)
    {
        $store = DB::table('stores')->where('id', $id);
        $table = 'stores';

        if (!$store->exists()) {
            $store = DB::table('substore')->where('id', $id);
            $table = 'substore';

            if (!$store->exists()) {
                return response()->json(['message' => 'Store not found.'], 404);
            }
        }

        try {
            DB::table($table)->where('id', $id)->update(['status' => false]);
            return response()->json(['message' => 'Store deactivated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to deactivate store.'], 500);
        }
    }
}
