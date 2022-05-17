<?php

namespace App\Http\Controllers;

use App\Mail\contactusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contactus(Request $request){
        $connection = @fsockopen("www.google.com", 80);
        if ($connection == true) {
            Mail::to('bouglina3@gmail.com')->send(new contactusMail($request->name,$request->email,$request->university,$request->faculty,$request->message));
            return back()->with('message', 'Email Successfully Sended!');
        } else {
            return back()->with('errorMessage', 'check your internet connection.');
        }
    }
}
