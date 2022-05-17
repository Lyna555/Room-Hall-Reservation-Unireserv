<?php

namespace App\Http\Controllers;

use App\Mail\deleteMail;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $sources = [
        [
            'model'      => '\\App\\Models\\Reservation',
            'date' => 'date',
            'room_name'      => 'room_name',
            'user_id'     => 'user_id',
            'creneaua'   => 'creneaua',
            'creneaude'     => 'creneaude',
            'satate'     => 'satate',
            'university'     => 'university',
            'faculty'     => 'faculty',
            'objective'     => 'objective',
            'route'      => '/admin/calendar',
        ],
    ];

    public function adminCalendar()
    {
        if (Auth::user()->role == 'admin') {
            $events = [];
            $count = Reservation::where('satate', '=', 'wait')->count();
            foreach ($this->sources as $source) {
                foreach ($source['model']::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get() as $model) {

                    $query = User::where('id', '=', $model->{$source['user_id']})->value('name');
                    $date = $model->getOriginal($source['date']);
                    $timestart = $model->getOriginal($source['creneaude']);
                    $timeend = $model->getOriginal($source['creneaua']);
                    $crudFieldValue = date('Y-m-d H:i', strtotime("$date $timestart"));
                    $crudFieldValue1 = date('Y-m-d H:i', strtotime("$date $timeend"));


                    if (!$crudFieldValue) {
                        continue;
                    }
                    if ($model->{$source['satate']} == 'reserved' || $model->{$source['satate']} == 'reserv-state') {

                        if ($model->{$source['date']} < Carbon::now()) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$source['room_name']}
                                    . " " . Carbon::parse($model->{$source['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$source['creneaua']})->format('H:i')." ".$model->{$source['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($source['route'], $model->id),
                                'color' => '#7fa1bc',
                            ];
                        } elseif (Auth::user()->id == $model->{$source['user_id']}) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$source['room_name']}
                                    . " " . Carbon::parse($model->{$source['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$source['creneaua']})->format('H:i')." ".$model->{$source['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($source['route'], $model->id),
                                'color' => '#f9a35c',
                            ];
                        } else {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$source['room_name']}
                                    . " " . Carbon::parse($model->{$source['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$source['creneaua']})->format('H:i')." ".$model->{$source['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($source['route'], $model->id),
                                'color' => '#92baff',
                            ];
                        }
                    }
                }
            }
            return view('admin.fullcalendar', compact('events', 'count'));
        } else {
            return abort(403);
        }
    }
    public $resources = [
        [
            'model'      => '\\App\\Models\\Reservation',
            'date' => 'date',
            'room_name'      => 'room_name',
            'user_id'     => 'user_id',
            'creneaua'   => 'creneaua',
            'creneaude'     => 'creneaude',
            'satate'     => 'satate',
            'university'     => 'university',
            'faculty'     => 'faculty',
            'objective'     => 'objective',
            'route'      => 'calendar',
        ],
    ];

    public function userCalendar()
    {
        if (Auth::user()->role == 'prof') {
            $events = [];
            $count = Reservation::where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->count();
            foreach ($this->resources as $resource) {
                foreach ($resource['model']::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get() as $model) {
                    $query = User::where('id', '=', $model->{$resource['user_id']})->value('name');
                    $date = $model->getOriginal($resource['date']);
                    $timestart = $model->getOriginal($resource['creneaude']);
                    $timeend = $model->getOriginal($resource['creneaua']);
                    $crudFieldValue = date('Y-m-d H:i', strtotime("$date $timestart"));
                    $crudFieldValue1 = date('Y-m-d H:i', strtotime("$date $timeend"));

                    if (!$crudFieldValue) {
                        continue;
                    }
                    if ($model->{$resource['satate']} == 'reserved' || $model->{$resource['satate']} == 'reserv-state') {
                        if ($model->{$resource['date']} < Carbon::now()) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$resource['room_name']}
                                    . " " . Carbon::parse($model->{$resource['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')." ".$model->{$resource['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($resource['route'], $model->id),
                                'color' => '#7fa1bc',
                            ];
                        } elseif (Auth::user()->id == $model->{$resource['user_id']}) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$resource['room_name']}
                                    . " " . Carbon::parse($model->{$resource['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')." ".$model->{$resource['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($resource['route'], $model->id),
                                'color' => '#f9a35c',
                            ];
                        } else {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$resource['room_name']}
                                    . " " . Carbon::parse($model->{$resource['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')." ".$model->{$resource['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($resource['route'], $model->id),
                                'color' => '#92baff',
                            ];
                        }
                    }
                }
            }
            return view('fullcalendar', compact('events', 'count'));
        } else {
            return abort(403);
        }
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
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            if ($search == '') {
                $users = User::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
                $reservations = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
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
            $count = Reservation::where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->count();
            if ($search == '') {
                $reservations = Reservation::where('user_id', '=', Auth::user()->id)->get();
                $sysdate = Carbon::now();
                return view('mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'count' => $count]);
            } else {
                $reservations = Reservation::where('user_id', '=', Auth::user()->id)
                    ->where('room_name', 'like', '%' . $search . '%')
                    ->orWhere('date', 'like', '%' . $search . '%')
                    ->orWhere('creneaude', 'like', '%' . $search . '%')
                    ->orWhere('creneaua', 'like', '%' . $search . '%')
                    ->orWhere('objective', 'like', '%' . $search . '%')
                    ->orderBy('room_name')
                    ->get();
                $sysdate = Carbon::now();
                return view('mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'count' => $count]);
            }
        } else {
            return abort(403);
        }
    }

    public function showNamesAdmin()
    {
        if (Auth::user()->role == 'admin') {
            $rooms = Room::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            return view('admin.mngReservations.addReservation', ['rooms' => $rooms, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function showNamesUser()
    {
        if (Auth::user()->role == 'prof') {
            $rooms = Room::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->count();
            return view('mngReservations.addReservation', ['rooms' => $rooms, 'count' => $count]);
        } else {
            return abort(403);
        }
    }
    public function showNotification()
    {
        if (Auth::user()->role == 'admin') {
            $sysdate = Carbon::now();
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            $reservations = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            return view('admin.notifications', ['reservations' => $reservations, 'sysdate' => $sysdate, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function showReserUser()
    {
        if (Auth::user()->role == 'prof') {
            $reservations = Reservation::where('user_id', Auth::user()->id)->where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->count();
            $sysdate = Carbon::now();
            return view('mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function showReserAdmin()
    {
        if (Auth::user()->role == 'admin') {
            $users = User::all();
            $reservations = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            $count = Reservation::where('satate', '=', 'wait')->where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->count();
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

        foreach ($reservations as $reser) {
            if ($reser->satate != 'reserv-ref') {
                if ($reser->university==Auth::user()->university && $reser->faculty==Auth::user()->faculty &&
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
            $rooms = Room::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
            $count = Reservation::where('user_id', '=', Auth::user()->id)->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->count();
            return view('mngReservations.editReservation', ['reservation' => $reservation, 'rooms' => $rooms, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function editAdmin($id)
    {
        if (Auth::user()->role == 'admin') {
            $reservation = Reservation::find($id);
            $rooms = Room::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->get();
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

        $reservations = Reservation::all();
        $reservation = Reservation::find($id);
        $request->validate(['id' => Rule::unique('reservations')->ignore($reservation->id)]);
        $reservation->room_name = $request->input('name');
        $reservation->date = $request->input('date');
        $reservation->creneaude = $request->input('creneaude');
        $reservation->creneaua = $request->input('creneaua');
        $reservation->objective = $request->input('objective');

        foreach ($reservations as $reser) {
            if ($reser->id != $reservation->id && $reser->satate != 'reserv-ref') {
                if ($reser->university==Auth::user()->university && $reser->faculty==Auth::user()->faculty &&
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
            return redirect('/admin/showReser')->with('message', 'Reservation successfully added!');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        if($reservation->user_id!=Auth::user()->id){
            Mail::to(User::where('id','=',$reservation->user_id)->value('email'))->send(new deleteReser($reservation));
        }
        $reservation->delete();
        return back()->with('message', 'Reservation successfully deleted!');
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
    public function notif()
    {
        if (Auth::user()->role == 'prof') {
            $notifications = Reservation::all();
            $user = Auth::user()->id;
            $count = Reservation::where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->count();
            return view('notifications', ['notifications' => $notifications, 'user' => $user, 'count' => $count]);
        } else {
            return abort(403);
        }
    }
}
