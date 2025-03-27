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
        $totalRecords = DB::table('mainvaluelists')->where('abbreviation', $abbreviation)->count();
        $columnIndex = $request->input('order.0.column');
        $columnDirection = $request->input('order.0.dir'); 
        $columnName = $request->input('columns.' . $columnIndex . '.data');
        if (empty($columnName)) {
            $columnName = 'name_en';
        }
        if (!in_array($columnDirection, ['asc', 'desc'])) {
            $columnDirection = 'asc'; 
        }
        $data = DB::table('mainvaluelists')
            ->where('abbreviation', $abbreviation)
            ->orderBy($columnName, $columnDirection) 
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->get();

    
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
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
