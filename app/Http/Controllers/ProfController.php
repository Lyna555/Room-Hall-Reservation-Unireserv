<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;

class ProfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showProf()
    {
        if (Auth::user()->role == 'admin') {
            $profs = User::all();
            return view('admin.prof', ['profs' => $profs]);
        } else {
            return abort(403);
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->role == 'admin') {
            $prof = User::find($id);
            $prof->delete();
            return back()->with('message', 'Professor successfully deleted!');
        } else {
            return abort(403);
        }
    }
}
