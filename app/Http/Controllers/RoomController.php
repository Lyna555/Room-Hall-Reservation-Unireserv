<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Room;
use App\Models\Reservation;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,['name'=>'unique:rooms||regex:/^[^"!*@#%$+]+$/']);
        $room = new Room();
        $room->name = $request->input('name');
        $room->capacity = $request->input('capacity');
        $room->floor = $request->input('floor');
        $room->type = $request->input('type');
        $room->state = $request->input('state');

        if(Str::contains($room->name,$room->type)){
            $room->save();
            return redirect('/showList')->with('message','Room/Hall successfully added!');
        }else{
            return back()->with('errorMessage','Room/Hall name doesn\'t match with the type');
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
        $rooms = Room::all();
        return view('admin.mngRooms.roomList',['rooms'=>$rooms]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::find($id);
        $rooms = Room::all();
        return view('admin.mngRooms.editRoom',['rooms'=>$rooms,'room'=>$room]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id){
        $room = Room::find($id);
        $request->validate(['name'=>Rule::unique('rooms')->ignore($room->id)]);
        $this->validate($request,['name'=>'regex:/^[^"!*@#%$+]+$/']);
        $room->name = $request->input('name');
        $room->capacity = $request->input('capacity');
        $room->floor = $request->input('floor');
        $room->type = $request->input('type');
        $room->state = $request->input('state');
        if(Str::contains($room->name,$room->type)){
            $room->save();
            return redirect('/showList')->with('message','Room/Hall successfully updated!');
        }else{
            return redirect()->back()->with('errorMessage','Room/Hall name doesn\'t match with the type');
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
        $room = Room::find($id);
        $reservations = Reservation::all();
        foreach($reservations as $reservation){
            if($reservation->room_id==$room->name){
                $reservation->delete();
            }
        }
        $room->delete();
        return back()->with('message','Room/Hall successfully deleted!');
    }
}
