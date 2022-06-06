<?php

namespace App\Http\Controllers;

use App\Mail\contactusMail;
use App\Mail\welcomeContactusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //add admin in database
    public function contactus(Request $request){
        $connection = @fsockopen("www.google.com", 80);
        if ($connection == true) {
            Mail::to('unireserv@gmail.com')->send(new contactusMail($request->name,$request->email,$request->university,$request->faculty,$request->message));
            return back()->with('message', 'Email Successfully Sended!');
        } else {
            return back()->with('errorMessage', 'check your internet connection.');
        }
    }

    //contactus in welcome page
    public function welcomeContactus(Request $request){
        $connection = @fsockopen("www.google.com", 80);
        if ($connection == true) {
            Mail::to('unireserv@gmail.com')->send(new welcomeContactusMail($request->message,$request->email));
            return back()->with('message', 'Email Successfully Sended!');
        } else {
            return back()->with('errorMessage', 'check your internet connection.');
        }
    }
}
