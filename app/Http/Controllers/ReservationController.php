<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use App\Mail\updateReserMail;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\deleteReser;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchAdmin(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $search = $request->input('cherche');
            $count = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            if ($search == '') {
                $users = User::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
                $reservations = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
                $sysdate = Carbon::now();
                $auth = Auth::user()->id;
                return view('admin.mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'users' => $users, 'auth' => $auth, 'count' => $count]);
            } else {
                $reservations = Reservation::join('users', 'reservations.user_id', '=', 'users.id')
                    ->where('room_name', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%')
                    ->orWhere('date', 'like', '%' . $search . '%')
                    ->orWhere('creneaude', 'like', '%' . $search . '%')
                    ->orWhere('creneaua', 'like', '%' . $search . '%')
                    ->orWhere('objective', 'like', '%' . $search . '%')
                    ->orderBy('room_name')
                    ->get();
                $users = User::all();
                $sysdate = Carbon::now();
                $auth = Auth::user();
                return view('admin.mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'users' => $users, 'auth' => $auth, 'count' => $count]);
            }
        } else {
            return abort(403);
        }
    }

    public function searchUser(Request $request)
    {
        if (Auth::user()->role == 'prof') {
            $search = $request->input('cherche');
            $count = Reservation::where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->count();
            if ($search == '') {
                $reservations = Reservation::where('user_id', '=', Auth::user()->id)->get();
                $sysdate = Carbon::now();
                return view('prof.mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'count' => $count]);
            } else {
                $reservations = Reservation::where('user_id', '=', Auth::user()->id)
                    ->where('room_name', 'like', '%' . $search . '%')
                    ->orWhere('date', 'like', '%' . $search . '%')
                    ->where('user_id', '=', Auth::user()->id)
                    ->orWhere('creneaude', 'like', '%' . $search . '%')
                    ->where('user_id', '=', Auth::user()->id)
                    ->orWhere('creneaua', 'like', '%' . $search . '%')
                    ->where('user_id', '=', Auth::user()->id)
                    ->orWhere('objective', 'like', '%' . $search . '%')
                    ->where('user_id', '=', Auth::user()->id)
                    ->orderBy('room_name')
                    ->get();
                $sysdate = Carbon::now();
                return view('prof.mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'count' => $count]);
            }
        } else {
            return abort(403);
        }
    }

    public function showNamesAdmin()
    {
        if (Auth::user()->role == 'admin') {
            $rooms = Room::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $count = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            return view('admin.mngReservations.addReservation', ['rooms' => $rooms, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function showNamesUser()
    {
        if (Auth::user()->role == 'prof') {
            $rooms = Room::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $count = Reservation::where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->count();
            return view('prof.mngReservations.addReservation', ['rooms' => $rooms, 'count' => $count]);
        } else {
            return abort(403);
        }
    }


    public function showReserUser()
    {
        if (Auth::user()->role == 'prof') {
            $reservations = Reservation::where('user_id', Auth::user()->id)->where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $count = Reservation::where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->count();
            $sysdate = Carbon::now();
            return view('prof.mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function showReserAdmin()
    {
        if (Auth::user()->role == 'admin') {
            $users = User::all();
            $reservations = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $count = Reservation::where('satate', '=', 'wait')->where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->count();
            $sysdate = Carbon::now();
            $auth = Auth::user();
            return view('admin.mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'users' => $users, 'auth' => $auth, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservations = Reservation::all();
        $reservation = new Reservation();
        $reservation->room_name = $request->input('name');
        $reservation->creneaude = $request->input('creneaude');
        $reservation->creneaua = $request->input('creneaua');
        $reservation->objective = $request->input('objective');
        $reservation->date = $request->input('date');
        $reservation->university = Auth::user()->university;
        $reservation->faculty = Auth::user()->faculty;
        $reservation->satate = 'reserved';

        $reservation->user_id = Auth::user()->id;
        $reservation->room_id = Room::where('name', '=', $request->input('name'))->value('id');

        foreach ($reservations as $reser) {
            if ($reser->satate != 'reserv-ref') {
                if (
                    $reser->university == Auth::user()->university && $reser->faculty == Auth::user()->faculty &&
                    $reser->room_name == $reservation->room_name && $reser->date == $reservation->date &&
                    (($reser->creneaude == $reservation->creneaude && $reser->creneaua == $reservation->creneaua) ||
                        ($reser->creneaude >= $reservation->creneaude && $reser->creneaua <= $reservation->creneaua) ||
                        ($reser->creneaude <= $reservation->creneaude && $reser->creneaua >= $reservation->creneaua) ||
                        ($reser->creneaude > $reservation->creneaude && $reser->creneaude < $reservation->creneaua) ||
                        ($reser->creneaua > $reservation->creneaude && $reser->creneaua < $reservation->creneaua))
                ) {
                    if (Auth::user()->role == 'admin') {
                        return redirect('/admin/showReser')->with('errorMessage', 'Reservation already exists!');
                        break;
                    } else {
                        return redirect('/user/showReser')->with('errorMessage', 'Reservation already exists!');
                        break;
                    }
                }
            }
        }
        $nowDate = Carbon::now();
        if ($reservation->date < $nowDate) {
            return back()->with('errorMessage', 'Date expired.')->withInput();
        } elseif ($reservation->creneaua <= $reservation->creneaude) {
            return back()->with('errorMessage', 'End-Time should be greater than Start-Time.')->withInput();
        } elseif (Auth::user()->role == 'admin') {
            $reservation->save();
            return redirect('/admin/showReser')->with('message', 'Reservation successfully added!')->withInput();
        } else {
            $verif = Room::where('name', '=', $reservation->room_name)->value('state');
            if ($verif == 'speacial') {
                $reservation->satate = 'wait';
                $reservation->save();
                if (Auth::user()->role == 'admin') {
                    return redirect('/admin/showReser')->with('message', 'Your reservation is sended successfully to the admin!');
                } else {
                    return redirect('/user/showReser')->with('message', 'Your reservation is sended successfully to the admin!');
                }
            } else {
                $reservation->save();
                return redirect('/user/showReser')->with('message', 'Reservation successfully added!');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUser($id)
    {
        if (Auth::user()->role == 'prof') {
            $reservation = Reservation::find($id);
            $rooms = Room::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $count = Reservation::where('user_id', '=', Auth::user()->id)->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->where('user_id', '=', Auth::user()->id)->where('user_id', '=', Auth::user()->id)->count();
            return view('prof.mngReservations.editReservation', ['reservation' => $reservation, 'rooms' => $rooms, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function editAdmin($id)
    {
        if (Auth::user()->role == 'admin') {
            $reservation = Reservation::find($id);
            $rooms = Room::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $count = Reservation::where('user_id', '=', Auth::user()->id)->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->where('satate', '=', 'wait')->count();
            return view('admin.mngReservations.editReservation', ['reservation' => $reservation, 'rooms' => $rooms, 'count' => $count]);
        } else {
            return abort(403);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reserr = Reservation::find($id);
        $reservations = Reservation::all();
        $reservation = Reservation::find($id);
        $request->validate(['id' => Rule::unique('reservations')->ignore($reservation->id)]);
        $reservation->room_name = $request->input('name');
        $reservation->date = $request->input('date');
        $reservation->creneaude = $request->input('creneaude');
        $reservation->creneaua = $request->input('creneaua');
        $reservation->objective = $request->input('objective');
        $reservation->room_id = Room::where('name', '=', $request->input('name'))->value('id');

        foreach ($reservations as $reser) {
            if ($reser->id != $reservation->id && $reser->satate != 'reserv-ref') {
                if (
                    $reser->university == Auth::user()->university && $reser->faculty == Auth::user()->faculty &&
                    $reser->room_name == $reservation->room_name && $reser->date == $reservation->date &&
                    (($reser->creneaude == $reservation->creneaude && $reser->creneaua == $reservation->creneaua) ||
                        ($reser->creneaude >= $reservation->creneaude && $reser->creneaua <= $reservation->creneaua) ||
                        ($reser->creneaude <= $reservation->creneaude && $reser->creneaua >= $reservation->creneaua) ||
                        ($reser->creneaude > $reservation->creneaude && $reser->creneaude < $reservation->creneaua) ||
                        ($reser->creneaua > $reservation->creneaude && $reser->creneaua < $reservation->creneaua))
                ) {
                    if (Auth::user()->role == 'admin') {
                        return redirect('/admin/showReser')->with('errorMessage', 'Reservation already exists!')->withInput();
                        break;
                    } else {
                        return redirect('/user/showReser')->with('errorMessage', 'Reservation already exists!')->withInput();
                        break;
                    }
                }
            }
        }

        $nowDate = Carbon::now();
        if ($reservation->date < $nowDate) {
            return back()->with('errorMessage', 'Date expired.')->withInput();
        } elseif ($reservation->creneaua <= $reservation->creneaude) {
            return back()->with('errorMessage', 'End-Time should be greater than Start-Time.')->withInput();
        } elseif (Auth::user()->role == 'admin') {
            $reservation->save();
            $connection = @fsockopen("www.google.com", 80);
            if ($connection == true) {
                if ($reservation->user_id != Auth::user()->id) {
                    Mail::to(User::where('id', '=', $reservation->user_id)->value('email'))->send(new updateReserMail($reserr, $reservation));
                }
            } else {
                return redirect('/admin/showReser')->with('errorMessage', 'Failed connection!');
            }
            return redirect('/admin/showReser')->with('message', 'Reservation successfully added!');
        } else {
            $verif = Room::where('name', '=', $reservation->room_name)->value('state');
            if ($verif == 'speacial') {
                $reservation->satate = 'wait';
                $reservation->save();
                return redirect('/user/showReser')->with('message', 'Your reservation is sended successfully to the admin!');
            } else {
                $reservation->save();
                return redirect('/user/showReser')->with('message', 'Reservation successfully added!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        $connection = @fsockopen("www.google.com", 80);
        if ($connection == true) {
            if ($reservation->user_id != Auth::user()->id) {
                Mail::to(User::where('id', '=', $reservation->user_id)->value('email'))->send(new deleteReser($reservation));
            } else {
                return redirect('/admin/showReser')->with('errorMessage', 'Failed connection!');
            }
        }
        $reservation->delete();
        return back()->with('message', 'Reservation successfully deleted!');
    }
}
