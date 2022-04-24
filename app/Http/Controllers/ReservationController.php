<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Auth;


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
            'date_field' => 'date',
            'end_field'  => 'date',
            'field'      => 'room_name',
            'prefix'     => 'user_id',
            'creneaua'   => 'creneaua',
            'suffix'     => 'creneaude',
            'satate'     => 'satate',
            'route'      => '/admin/calendar',
        ],
    ];

    public function adminCalendar()
    {
        if (Auth::user()->role == 'admin') {
            $events = [];
            foreach ($this->sources as $source) {
                foreach ($source['model']::all() as $model) {

                    $query = User::where('id', '=', $model->{$source['prefix']})->value('name');
                    $crudFieldValue = $model->getOriginal($source['date_field']);

                    if (!$crudFieldValue) {
                        continue;
                    }
                    if ($model->{$source['satate']} == 'reserved' || $model->{$source['satate']} == 'reserv-state') {

                        if ($model->{$source['end_field']} < Carbon::now()) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$source['field']}
                                    . " " . Carbon::parse($model->{$source['suffix']})->format('H:i') . " " . Carbon::parse($model->{$source['creneaua']})->format('H:i')),
                                'start' => $crudFieldValue,
                                'end'   => $model->{$source['end_field']},
                                'url'   => route($source['route'], $model->id),
                                'color' => '#7fa1bc',
                            ];
                        } elseif (Auth::user()->id == $model->{$source['prefix']}) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$source['field']}
                                    . " " . Carbon::parse($model->{$source['suffix']})->format('H:i') . " " . Carbon::parse($model->{$source['creneaua']})->format('H:i')),
                                'start' => $crudFieldValue,
                                'end'   => $model->{$source['end_field']},
                                'url'   => route($source['route'], $model->id),
                                'color' => '#f9a35c',
                            ];
                        } else {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$source['field']}
                                    . " " . Carbon::parse($model->{$source['suffix']})->format('H:i') . " " . Carbon::parse($model->{$source['creneaua']})->format('H:i')),
                                'start' => $crudFieldValue,
                                'end'   => $model->{$source['end_field']},
                                'url'   => route($source['route'], $model->id),
                                'color' => '#92baff',
                            ];
                        }
                    }
                }
            }
            return view('admin.fullcalendar', compact('events'));
        } else {
            return abort(403);
        }
    }
    public $resources = [
        [
            'model'      => '\\App\\Models\\Reservation',
            'date_field' => 'date',
            'end_field'  => 'date',
            'field'      => 'room_name',
            'prefix'     => 'user_id',
            'creneaua'   => 'creneaua',
            'suffix'     => 'creneaude',
            'satate'     => 'satate',
            'route'      => 'calendar',
        ],
    ];

    public function userCalendar()
    {
        if (Auth::user()->role == 'prof') {
            $events = [];
            foreach ($this->resources as $resource) {
                foreach ($resource['model']::all() as $model) {
                    $query = User::where('id', '=', $model->{$resource['prefix']})->value('name');
                    $crudFieldValue = $model->getOriginal($resource['date_field']);

                    if (!$crudFieldValue) {
                        continue;
                    }
                    if ($model->{$resource['satate']} == 'reserved' || $model->{$resource['satate']} == 'reserv-state') {
                        if ($model->{$resource['end_field']} < Carbon::now()) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$resource['field']}
                                    . " " . Carbon::parse($model->{$resource['suffix']})->format('H:i') . " " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')),
                                'start' => $crudFieldValue,
                                'end'   => $model->{$resource['end_field']},
                                'url'   => route($resource['route'], $model->id),
                                'color' => '#7fa1bc',
                            ];
                        } elseif (Auth::user()->id == $model->{$resource['prefix']}) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$resource['field']}
                                    . " " . Carbon::parse($model->{$resource['suffix']})->format('H:i') . " " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')),
                                'start' => $crudFieldValue,
                                'end'   => $model->{$resource['end_field']},
                                'url'   => route($resource['route'], $model->id),
                                'color' => '#f9a35c',
                            ];
                        } else {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$resource['field']}
                                    . " " . Carbon::parse($model->{$resource['suffix']})->format('H:i') . " " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')),
                                'start' => $crudFieldValue,
                                'end'   => $model->{$resource['end_field']},
                                'url'   => route($resource['route'], $model->id),
                                'color' => '#92baff',
                            ];
                        }
                    }
                }
            }
            return view('fullcalendar', compact('events'));
        } else {
            return abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function showNamesAdmin()
    {
        if (Auth::user()->role == 'admin') {
            $rooms = Room::all();
            return view('admin.mngReservations.addReservation', ['rooms' => $rooms]);
        } else {
            return abort(403);
        }
    }

    public function showNamesUser()
    {
        if (Auth::user()->role == 'prof') {
            $rooms = Room::all();
            return view('mngReservations.addReservation', ['rooms' => $rooms]);
        } else {
            return abort(403);
        }
    }
    public function showNotification()
    {
        if (Auth::user()->role == 'admin') {
            $sysdate = Carbon::now();
            $reservations = Reservation::all();
            return view('admin.notifications', ['reservations' => $reservations, 'sysdate' => $sysdate]);
        } else {
            return abort(403);
        }
    }

    public function showReserUser()
    {
        if (Auth::user()->role == 'prof') {
            $reservations = Reservation::where('user_id', Auth::user()->id)->get();
            $sysdate = Carbon::now();
            return view('mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate]);
        } else {
            return abort(403);
        }
    }

    public function showReserAdmin()
    {
        if (Auth::user()->role == 'admin') {
            $reservations = Reservation::all();
            $sysdate = Carbon::now();
            return view('admin.mngReservations.ReserList', ['reservations' => $reservations, 'sysdate' => $sysdate]);
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
        $reservation->satate = 'reserved';

        $reservation->user_id = Auth::user()->id;

        foreach ($reservations as $reser) {
            if ($reser->satate != 'reserv-ref') {
                if ($reser->room_name == $reservation->room_name && $reser->date == $reservation->date && (
                    ($reser->creneaude >= $reservation->creneaude && $reser->creneaua <= $reservation->creneaua) ||
                    ($reser->creneaude <= $reservation->creneaude && $reser->creneaua >= $reservation->creneaua) ||
                    ($reser->creneaude < $reservation->creneaude && $reser->creneaua > $reservation->creneaude) ||
                    ($reser->creneaua < $reservation->creneaua && $reser->creneaua > $reservation->creneaua))) {
                    if (Auth::user()->role == 'admin') {
                        return redirect('/admin/showReser')->with('errorMessage', 'Reservation already exists!');
                    } else {
                        return redirect('/user/showReser')->with('errorMessage', 'Reservation already exists!');
                    }
                }
            }
        }
        $nowDate = Carbon::now();
        if ($reservation->date < $nowDate) {
            return back()->with('errorMessage', 'Date expired.');
        } elseif ($reservation->creneaua <= $reservation->creneaude) {
            return back()->with('errorMessage', 'End-Time should be greater than Start-Time.');
        } elseif (Auth::user()->role == 'admin') {
            $reservation->save();
            return redirect('/admin/showReser')->with('message', 'Reservation successfully added!');
        } else {
            $verif = Room::where('name', '=', $reservation->room_name)->value('state');
            if ($verif == 'speacial') {
                $reservation->satate = 'wait';
                $reservation->save();
                if (Auth::user()->role == 'admin') {
                    return redirect('/admin/showReser')->with('Message', 'Your reservation is sended successfully to the admin!');
                } else {
                    return redirect('/user/showReser')->with('Message', 'Your reservation is sende successfully to the admin!');
                }
            } else {
                $reservation->save();
                return redirect('/user/showReser')->with('message', 'Reservation successfully added!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            $rooms = Room::all();
            return view('mngReservations.editReservation', ['reservation' => $reservation, 'rooms' => $rooms]);
        } else {
            return abort(403);
        }
    }

    public function editAdmin($id)
    {
        if (Auth::user()->role == 'admin') {
            $reservation = Reservation::find($id);
            $rooms = Room::all();
            return view('admin.mngReservations.editReservation', ['reservation' => $reservation, 'rooms' => $rooms]);
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
        $reservation->date = $request->input('date');
        $reservation->creneaude = $request->input('creneaude');
        $reservation->creneaua = $request->input('creneaua');
        $reservation->objective = $request->input('objective');

        foreach ($reservations as $reser) {
            if ($reser->id != $reservation->id && $reser->satate != 'reserv-ref') {
                if ($reser->room_name == $reservation->room_name && $reser->date == $reservation->date && (
                    ($reser->creneaude >= $reservation->creneaude && $reser->creneaua <= $reservation->creneaua) ||
                    ($reser->creneaude <= $reservation->creneaude && $reser->creneaua >= $reservation->creneaua) ||
                    ($reser->creneaude < $reservation->creneaude && $reser->creneaua > $reservation->creneaude) ||
                    ($reser->creneaua < $reservation->creneaua && $reser->creneaua > $reservation->creneaua))) {
                    if (Auth::user()->role == 'admin') {
                        return redirect('/admin/showReser')->with('errorMessage', 'Reservation already exists!');
                    } else {
                        return redirect('/user/showReser')->with('errorMessage', 'Reservation already exists!');
                    }
                }
            }
        }

        $nowDate = Carbon::now();
        if ($reservation->date < $nowDate) {
            return back()->with('errorMessage', 'Date expired.');
        } elseif ($reservation->creneaua <= $reservation->creneaude) {
            return back()->with('errorMessage', 'End-Time should be greater than Start-Time.');
        } elseif (Auth::user()->role == 'admin') {
            $reservation->save();
            return redirect('/admin/showReser')->with('message', 'Reservation successfully added!');
        } else {
            $verif = Room::where('name', '=', $reservation->room_name)->value('state');
            if ($verif == 'speacial') {
                $reservation->satate = 'wait';
                $reservation->save();
                if (Auth::user()->role == 'admin') {
                    return redirect('/admin/showReser')->with('Message', 'Your reservation is sended successfully to the admin!');
                } else {
                    return redirect('/user/showReser')->with('Message', 'Your reservation is sende successfully to the admin!');
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
            return view('notifications', ['notifications' => $notifications, 'user' => $user]);
        } else {
            return abort(403);
        }
    }
}
