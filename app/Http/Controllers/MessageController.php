<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\SendEmail;
use Mail;
use Auth;

class MessageController extends Controller
{
    public function emails(){
        $users = User::all();
        return view('admin.contact',['users'=>$users]);
    }

    public function sendEmail(Request $request){
       Mail::to($request->input('email'))->send(new WelcomEmail());
       return back()->with('message','Email Successfully Sended!');

    }

    public function emailsUser(){
        $users = User::all();
        return view('contact',['users'=>$users]);
    }

    public function sendEmailUser(Request $request){
       Mail::to($request->input('email'))->send(new SendEmail());
       return back()->with('message','Email Successfully Sended!');

    }
    
}
