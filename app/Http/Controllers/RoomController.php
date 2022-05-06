<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Room;
use App\Models\Reservation;
use Auth;

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
            $count = Reservation::where('satate','=','wait')->count();
            if ($search == '') {
                $rooms = Room::all();
                $reservations = Reservation::all();
                $i = 0;
                return view('admin.mngRooms.roomList', ['rooms' => $rooms, 'reservations' => $reservations, 'i' => $i,'count'=>$count]);
            } else {
                $rooms = Room::where('name', 'like', '%' . $search . '%')
                    ->orWhere('capacity', 'like', '%' . $search . '%')
                    ->orWhere('floor', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('state', 'like', '%' . $search . '%')
                    ->orderBy('name')
                    ->get();
                $reservations = Reservation::all();
                $i = 0;
                return view('admin.mngRooms.roomList', ['rooms' => $rooms, 'reservations' => $reservations, 'i' => $i,'count'=>$count]);
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
            $this->validate($request, ['name' => 'unique:rooms||regex:/^[^"!*@#%$+]+$/']);
            $room = new Room();
            $room->name = $request->input('name');
            $room->capacity = $request->input('capacity');
            $room->floor = $request->input('floor');
            $room->type = $request->input('type');
            $room->state = $request->input('state');

            if (Str::contains($room->name, $room->type)) {
                $room->save();
                return redirect('/showList')->with('message', 'Room/Hall successfully added!');
            } else {
                return back()->with('errorMessage', 'Room/Hall name doesn\'t match with the type')->withInput();
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
            $rooms = Room::all();
            $reservations = Reservation::all();
            $count = Reservation::where('satate','=','wait')->count();
            $i = 0;
            return view('admin.mngRooms.roomList', ['rooms' => $rooms, 'reservations' => $reservations, 'i' => $i,'count'=>$count]);
        } else {
            return abort(403);
        }
    }

    public function addRoom(){
        $count = Reservation::where('satate','=','wait')->count();
        return view('admin.mngRooms.addRoom',compact('count'));
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
            $rooms = Room::all();
            $count = Reservation::where('satate','=','wait')->count();
            return view('admin.mngRooms.editRoom', ['rooms' => $rooms, 'room' => $room,'count'=>$count]);
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
            $request->validate(['name' => Rule::unique('rooms')->ignore($room->id)]);
            $this->validate($request, ['name' => 'regex:/^[^"!*@#%$+]+$/']);
            $room->name = $request->input('name');
            $room->capacity = $request->input('capacity');
            $room->floor = $request->input('floor');
            $room->type = $request->input('type');
            $room->state = $request->input('state');
            if (Str::contains($room->name, $room->type)) {
                $room->save();
                return redirect('/showList')->with('message', 'Room/Hall successfully updated!');
            } else {
                return redirect()->back()->with('errorMessage', 'Room/Hall name doesn\'t match with the type');
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
            $reservations = Reservation::all();
            foreach ($reservations as $reservation) {
                if ($reservation->room_name == $room->name) {
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
