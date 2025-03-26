<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    //
    public function index()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        return View('Home.index');
    }

    public function dashboard()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        return View('Home.dashboard');
    }
}
