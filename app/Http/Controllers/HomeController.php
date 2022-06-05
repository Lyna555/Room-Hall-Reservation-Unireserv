<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('satate','=','wait')->count();
            return view('admin.dashboard',compact('count'));
        } else {
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('date','>=',Carbon::now())->where('user_id','=',Auth::user()->id)->where('satate','=','reserv-state')->orWhere('satate','=','reserv-ref')->count();
            return view('prof.dashboard',compact('count'));
        }
    }
}
