<?php

namespace App\Http\Controllers;

use App\Helpers\Acl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->hasRole(Acl::ROLE_SUPERADMIN)) {
            return redirect(route('superadmin.users.index'));
        } else {
            return redirect(route('company.map.index'));
        }
           
    }

    
}
