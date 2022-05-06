<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Auth;

class ProfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $search = $request->input('cherche');
            $count = Reservation::where('satate', '=', 'wait')->count();
            if ($search == '') {
                $profs = User::all();
                return view('admin.prof', ['profs' => $profs,'count' => $count]);
            } else {
                $profs = User::where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orderBy('name')
                    ->get();
                return view('admin.prof', ['profs' => $profs,'count' => $count]);
            }
        } else {
            return abort(403);
        }
    }

    public function showProf()
    {
        if (Auth::user()->role == 'admin') {
            $profs = User::all();
            $count = Reservation::where('satate', '=', 'wait')->count();
            return view('admin.prof', ['profs' => $profs,'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->role == 'admin') {
            $prof = User::find($id);
            $reservations = Reservation::all();
            foreach ($reservations as $reservation) {
                if ($reservation->user_id == $prof->id) {
                    $reservation->delete();
                }
            }
            $prof->delete();
            return back()->with('message', 'Professor successfully deleted!');
        } else {
            return abort(403);
        }
    }
}
