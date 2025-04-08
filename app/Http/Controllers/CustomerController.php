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
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return View('social.unauthorized');
        }

        $noPhoto = base64_encode(file_get_contents('files/userimg/nophoto.jpg'));

        $customers = DB::table('customers')->where('active', true)->get();
            
        return View('customer.index')
        ->with('noPhoto', $noPhoto)
        ->with('customers', $customers);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);
    
        Customer::create([
            'ownerName' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'active' => true
        ]);
    
        return redirect()->route('customer.index')->with('success', 'Customer added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    dd($id);  // This should dump the customer ID

    $customer = Customer::find($id);

    if (!$customer) {
        return response()->json(['message' => 'Customer not found.'], 404);
    }

    try {
        $customer->active = false;
        $customer->save();

        return response()->json(['message' => 'Customer deactivated successfully.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to deactivate customer.'], 500);
    }
}

    
}
