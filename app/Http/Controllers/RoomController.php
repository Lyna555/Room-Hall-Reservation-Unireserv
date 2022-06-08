<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Room;
use App\Models\Reservation;
use App\Mail\deleteMail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use FFI;
use Illuminate\Support\Facades\Mail;

class RoomController extends Controller
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
    public function search(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            $search = $request->input('cherche');
            $count = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            if ($search == '') {
                $rooms = Room::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
                $reservations = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
                $i = 0;
                return view('admin.mngRooms.roomList', ['rooms' => $rooms, 'reservations' => $reservations, 'i' => $i, 'count' => $count]);
            } else {
                $auth = Auth::user();
                $rooms = Room::where('name', 'like', '%' . $search . '%')
                    ->orWhere('capacity', 'like', '%' . $search . '%')
                    ->orWhere('floor', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('state', 'like', '%' . $search . '%')
                    ->orderBy('name')
                    ->get();
                $reservations = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
                $i = 0;
                return view('admin.mngRooms.roomList', ['auth' => $auth, 'rooms' => $rooms, 'reservations' => $reservations, 'i' => $i, 'count' => $count]);
            }
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
        if (Auth::user()->role == 'admin') {
            $rooms = Room::all();
            $room = new Room();
            $room->name = $request->input('type') . $request->input('number');
            $room->capacity = $request->input('capacity');
            $room->floor = $request->input('floor');
            $room->type = $request->input('type');
            $room->state = $request->input('state');
            $room->university = Auth::user()->university;
            $room->faculty = Auth::user()->faculty;
            $co = 0;

            foreach ($rooms as $rm) {
                if ($rm->name == $room->name && $rm->university == Auth::user()->university && $rm->faculty == Auth::user()->faculty) {
                    $co = 1;
                    break;
                }
            }
            if ($co == 1) {
                return redirect('/showList')->with('errorMessage', 'Room/Hall exists allready!')->withInput();
            } else {
                $room->save();
                return redirect('/showList')->with('message', 'Room/Hall successfully added!');
            }
        } else {
            return abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function showList()
    {
        if (Auth::user()->role == 'admin') {
            $auth = Auth::user();
            $rooms = Room::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $reservations = Reservation::all();
            $count = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            $i = 0;
            return view('admin.mngRooms.roomList', ['auth' => $auth, 'rooms' => $rooms, 'reservations' => $reservations, 'i' => $i, 'count' => $count]);
        } else {
            return abort(403);
        }
    }

    public function addRoom()
    {
        $count = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->where('satate', '=', 'wait')->count();
        return view('admin.mngRooms.addRoom', compact('count'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role == 'admin') {
            $room = Room::find($id);
            $name = $room->name;
            $num = (int)filter_var($name, FILTER_SANITIZE_NUMBER_INT);
            $num = strval($num);
            $rooms = Room::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $count = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            return view('admin.mngRooms.editRoom', ['rooms' => $rooms, 'room' => $room, 'count' => $count, 'num' => $num]);
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
        if (Auth::user()->role == 'admin') {
            $room = Room::find($id);
            $roomy= $room->name;
            $rooms = Room::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            $request->validate(['name' => Rule::unique('rooms')->ignore($room->id)]);
            $this->validate($request, ['name' => 'regex:/^[^"!*@#%$+]+$/']);
            $room->name = $request->input('type') . $request->input('number');
            $room->capacity = $request->input('capacity');
            $room->floor = $request->input('floor');
            $room->type = $request->input('type');
            $room->state = $request->input('state');
            $reser=Room::join('reservations','rooms.id','reservations.room_id')->where('reservations.room_name','=',$roomy)->count();
            $co = 0; 

            if($reser>0){
                return redirect('/showList')->with('errorMessage', 'This room is reserved, you can\'t change it\'s name');
            }

            foreach ($rooms as $rm) {
                if ($rm->name == $room->name && $rm->university == Auth::user()->university && $rm->faculty == Auth::user()->faculty) {
                    $co = 1;
                    break;
                }
            }
            if ($co == 1) {
                return redirect('/showList')->with('errorMessage', 'Room/Hall exists allready!');
            } else {
                $room->save();
                return redirect('/showList')->with('message', 'Room/Hall successfully added!');
            }
        } else {
            return abort(403);
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
        if (Auth::user()->role == 'admin') {
            $room = Room::find($id);
            $reservations = Reservation::where('university', '=', Auth::user()->university)->where('faculty', '=', Auth::user()->faculty)->get();
            foreach ($reservations as $reservation) {
                if ($reservation->room_name == $room->name) {
                    Mail::to(User::where('id', '=', $reservation->user_id)->value('email'))->send(new deleteMail($reservation));
                    $reservation->delete();
                }
            }
            $room->delete();
            return back()->with('message', 'Room/Hall successfully deleted!');
        } else {
            return abort(403);
        }
    }
}
