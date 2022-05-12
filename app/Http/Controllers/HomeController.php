<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Reservation;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $count = Reservation::where('satate','=','wait')->count();
            return view('admin.dashboard',compact('count'));
        } else {
            $count = Reservation::where('date','>=',Carbon::now())->where('user_id','=',Auth::user()->id)->where('satate','=','reserv-state')->orWhere('satate','=','reserv-ref')->count();
            return view('dashboard',compact('count'));
        }
    }
}
