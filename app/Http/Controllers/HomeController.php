<?php

namespace App\Http\Controllers;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            return view('admin.dashboard');
        } else {
            return view('dashboard');
        }
    }
}
