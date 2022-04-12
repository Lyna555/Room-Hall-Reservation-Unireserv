<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\SendEmail;
use App\Mail\WelcomEmail;
use Mail;

class MessageController extends Controller
{
    public function emails()
    {
        $users = User::all();
        return view('admin.contact', ['users' => $users]);
    }

    public function sendEmail(Request $request)
    {
        $connection = @fsockopen("www.google.com", 80);
        if ($connection == true) {
            Mail::to($request->input('email'))->send(new WelcomEmail());
            return back()->with('message', 'Email Successfully Sended!');
        } else {
            return back()->with('message', 'check your internet connection.');
        }
    }

    public function emailsUser()
    {
        $users = User::all();
        return view('contact', ['users' => $users]);
    }

    public function sendEmailUser(Request $request)
    {
        $connection = @fsockopen("www.google.com", 80);
        if ($connection == true) {
            Mail::to($request->input('email'))->send(new SendEmail());
            return back()->with('message', 'Email Successfully Sended!');
        } else {
            return back()->with('message', 'check your internet connection.');
        }
    }
}
