<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function adminNotif()
    {
        if (Auth::user()->role == 'admin') {
            $sysdate = Carbon::now();
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            $reservations = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            $users = User::all();
            return view('admin.notifications', ['reservations' => $reservations, 'sysdate' => $sysdate, 'count' => $count,'users'=>$users]);
        } else {
            return abort(403);
        }
    }

    public function accept($id)
    {
        if (Auth::user()->role == 'admin') {
            $reservation = Reservation::find($id);
            $reservation->satate = 'reserv-state';
            $reservation->message = 'Your reservation is accepted';
            $reservation->save();
            return redirect('/admin/notifications');
        } else {
            return abort(403);
        }
    }

    public function refuse($id)
    {
        if (Auth::user()->role == 'admin') {
            $reservation = Reservation::find($id);
            $reservation->satate = 'reserv-ref';
            $reservation->message = 'Your reservation is refused';
            $reservation->save();
            return redirect('/admin/notifications');
        } else {
            return abort(403);
        }
    }
    public function userNotif()
    {
        if (Auth::user()->role == 'prof') {
            $notifications = Reservation::all();
            $user = Auth::user()->id;
            $now = Carbon::now();
            $count = Reservation::where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->count();
            return view('prof.notifications', ['notifications' => $notifications, 'user' => $user, 'count' => $count,'now'=>$now]);
        } else {
            return abort(403);
        }
    }
}
