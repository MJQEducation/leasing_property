<?php

namespace App\Http\Controllers;

use App\Helper\RBAC;
use Illuminate\Routing\Route;

class DashboardController extends Controller
{
    public function index()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return View('social.unauthorized');
        }

        return View('Dashboard.index');
    }
}
