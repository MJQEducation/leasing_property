<?php

namespace App\Http\Controllers;

use App\Helper\ExitClearanceHelper;
use App\Helper\RBAC;
use App\Jobs\Jobs;
use App\Models\ExitClearance;
use App\Models\ExitClearanceBulletin;
use App\Models\ExitClearanceCheckList;
use App\Models\ExitClearanceSignature;
use App\Models\User;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class AbbreviationController extends Controller
{
    public function show(Request $request)
    {
        $abbreviation = $request->route('abbreviation');    
    
        if ($abbreviation == 'sub') {
            $query = DB::table('substore')->where('status', 1);
        } else {
            $query = DB::table('stores')->where('status', 1)->where('abbreviation', $abbreviation);
        }
    
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('store_code', 'LIKE', "%{$search}%")
                  ->orWhere('name_en', 'LIKE', "%{$search}%")
                  ->orWhere('name_kh', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }
    
        $totalRecordsFiltered = $query->count();
    
        $perPage = $request->input('length', 10);  
        $start = $request->input('start', 0);  
    
        $columnIndex = $request->input('order.0.column');
        $columnDirection = $request->input('order.0.dir');
        $columnName = $request->input('columns.' . $columnIndex . '.data', 'name_en');
        if (!in_array($columnDirection, ['asc', 'desc'])) {
            $columnDirection = 'asc';
        }
    
        $query = $query->orderBy($columnName, $columnDirection)
                       ->skip($start)
                       ->take($perPage);
    
        $data = $query->get();
    
        if ($abbreviation == 'sub') {
            $totalRecords = DB::table('substore')->where('status', 1)->count();  
        } else {
            $totalRecords = DB::table('stores')->where('status', 1)->where('abbreviation', $abbreviation)->count();  
        }
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,  
            'recordsFiltered' => $totalRecordsFiltered, 
            'data' => $data,  
        ]);
    }
    




    

    
    public function index()
    {
        return view('Abbreviation.index');
    }
    
    public function add()
    {
        return view('Abbreviation.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'abbreviation' => 'required',
            'description' => 'required',
        ]);

        DB::table('abbreviation')->insert([
            'abbreviation' => $request->abbreviation,
            'description' => $request->description,
        ]);

        return redirect('/abbreviation/index');
    }

    public function edit($id)
    {
        $data = DB::table('abbreviation')->where('id', $id)->first();
        return view('Abbreviation.edit', ['data' => $data]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'abbreviation' => 'required',
            'description' => 'required',
        ]);

        DB::table('abbreviation')->where('id', $request->id)->update([
            'abbreviation' => $request->abbreviation,
            'description' => $request->description,
        ]);

        return redirect('/abbreviation/index');
    }

    public function delete($id)
    {
        DB::table('abbreviation')->where('id', $id)->delete();
        return redirect('/abbreviation/index');
    }
}
