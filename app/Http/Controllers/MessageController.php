<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\SendEmail;
use App\Mail\WelcomEmail;
use App\Mail\contactusMail;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function emails()
    {
        if (Auth::user()->role == 'admin') {
            $users = User::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            $auth = Auth::user()->email;
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('satate','=','wait')->count();
            return view('admin.contact', ['users' => $users ,'auth' => $auth,'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function sendEmail(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $connection = @fsockopen("www.google.com", 80);
            if ($connection == true) {
                Mail::to($request->input('email'))->send(new WelcomEmail());
                return back()->with('message', 'Email Successfully Sended!');
            } else {
                return back()->with('error', 'check your internet connection!');
            }
        } else {
            return abort(403);
        }
    }

    public function emailsUser()
    {
        if (Auth::user()->role == 'prof') {
            $users = User::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            $auth = Auth::user()->email;
            $count = Reservation::where('date','>=',Carbon::now())->where('user_id','=',Auth::user()->id)->where('satate','=','reserv-state')->orWhere('satate','=','reserv-ref')->count();
            return view('contact', ['users' => $users ,'auth' => $auth,'count'=> $count]);
        } else {
            return abort(403);
        }
    }

    public function sendEmailUser(Request $request)
    {
        if (Auth::user()->role == 'prof') {
            $connection = @fsockopen("www.google.com", 80);
            if ($connection == true) {
                Mail::to($request->email)->send(new SendEmail());
                return back()->with('message', 'Email Successfully Sended!');
            } else {
                return back()->with('error', 'check your internet connection!');
            }
        } else {
            return abort(403);
        }
    }
}
