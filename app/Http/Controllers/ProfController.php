<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class ProfController extends Controller
{
    public function showProf()
    {
        $profs = User::all();
        return view('admin.prof',['profs'=>$profs]);
    }

    public function destroy($id)
    {
        $prof = User::find($id);
        $prof->delete();
        return back()->with('message','Professor successfully deleted!');
    }
}
