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
        $events = [];
        foreach ($this->sources as $source) {
            foreach ($source['model']::all() as $model) {
        $query=User::where('id','=',$model->{$source['prefix']})->value('name');
                $crudFieldValue = $model->getOriginal($source['date_field']);

                if (!$crudFieldValue) {
                    continue;
                }
                if($model->{$source['satate']}=='reserved'){

                if($model->{$source['end_field']}<Carbon::now()){
                    $events[] = [
                        'title' => trim($query . " " . $model->{$source['field']}
                            . " " . Carbon::parse($model->{$source['suffix']})->format('H:i'). " " . Carbon::parse($model->{$source['creneaua']})->format('H:i')),
                        'start' => $crudFieldValue,
                        'end'   => $model->{$source['end_field']},
                        'url'   => route($source['route'], $model->id),
                        'color' =>'gray',
                    ];
                }elseif(Auth::user()->id==$model->{$source['prefix']}){
                $events[] = [
                    'title' => trim($query . " " . $model->{$source['field']}
                        . " " . Carbon::parse($model->{$source['suffix']})->format('H:i'). " " . Carbon::parse($model->{$source['creneaua']})->format('H:i')),
                    'start' => $crudFieldValue,
                    'end'   => $model->{$source['end_field']},
                    'url'   => route($source['route'], $model->id),
                    'color'=>'brown',
                ];
            }else{
                $events[] = [
                    'title' => trim($query . " " . $model->{$source['field']}
                        . " " . Carbon::parse($model->{$source['suffix']})->format('H:i'). " " . Carbon::parse($model->{$source['creneaua']})->format('H:i')),
                    'start' => $crudFieldValue,
                    'end'   => $model->{$source['end_field']},
                    'url'   => route($source['route'], $model->id),
                    'color' =>'cadetblue',
                ];
            }
            
            }
        }
    }
        return view('admin.fullcalendar', compact('events'));
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
            'route'      => 'calendar',
        ],
    ];

    public function userCalendar()
    {
        $events = [];
        foreach ($this->resources as $resource) {
            foreach ($resource['model']::all() as $model) {
        $query=User::where('id','=',$model->{$resource['prefix']})->value('name');
                $crudFieldValue = $model->getOriginal($resource['date_field']);

                if (!$crudFieldValue) {
                    continue;
                }
                if($model->{$source['satate']}=='reserved'){
                if($model->{$resource['end_field']}<Carbon::now()){
                    $events[] = [
                        'title' => trim($query . " " . $model->{$resource['field']}
                            . " " . Carbon::parse($model->{$resource['suffix']})->format('H:i'). " " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')),
                        'start' => $crudFieldValue,
                        'end'   => $model->{$resource['end_field']},
                        'url'   => route($resource['route'], $model->id),
                        'color' =>'gray',
                    ];
                }elseif(Auth::user()->id==$model->{$resource['prefix']}){
                $events[] = [
                    'title' => trim($query . " " . $model->{$resource['field']}
                        . " " . Carbon::parse($model->{$resource['suffix']})->format('H:i'). " " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')),
                    'start' => $crudFieldValue,
                    'end'   => $model->{$resource['end_field']},
                    'url'   => route($resource['route'], $model->id),
                    'color'=>'brown',
                ];
            }else{
                $events[] = [
                    'title' => trim($query . " " . $model->{$resource['field']}
                        . " " . Carbon::parse($model->{$resource['suffix']})->format('H:i'). " " . Carbon::parse($model->{$resource['creneaua']})->format('H:i')),
                    'start' => $crudFieldValue,
                    'end'   => $model->{$resource['end_field']},
                    'url'   => route($resource['route'], $model->id),
                    'color' =>'cadetblue',
                ];
            }
            
            }
        }
    }
        return view('fullcalendar', compact('events'));
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
        $rooms = Room::all();
        return view('admin.mngReservations.addReservation',['rooms'=>$rooms]);
    }

    public function showNamesUser()
    {
        $rooms = Room::all();
        return view('mngReservations.addReservation',['rooms'=>$rooms]);
    }
    public function showNotification()
    {
        $sysdate = Carbon::now();
        $reservations=Reservation::all();
        return view('admin.notifications',['reservations'=>$reservations,'sysdate'=>$sysdate]);
    }

    public function showReserUser()
    {
        $reservations = Reservation::where('user_id', Auth::user()->id)->get();
        $sysdate = Carbon::now();
        return view('mngReservations.ReserList',['reservations'=>$reservations,'sysdate'=>$sysdate]);
    }

    public function showReserAdmin()
    {
        $reservations = Reservation::all();
        $sysdate = Carbon::now();
        return view('admin.mngReservations.ReserList',['reservations'=>$reservations,'sysdate'=>$sysdate]);
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
        
        foreach($reservations as $reser){
            if($reser->room_name==$reservation->room_name && $reser->date==$reservation->date && (
            ($reser->creneaude>=$reservation->creneaude && $reser->creneaua<=$reservation->creneaua)||
            ($reser->creneaude<=$reservation->creneaude && $reser->creneaua>=$reservation->creneaua)|| 
            ($reser->creneaude<$reservation->creneaude && $reser->creneaua>$reservation->creneaude)||
            ($reser->creneaua<$reservation->creneaua && $reser->creneaua>$reservation->creneaua))){
                return back()->with('errorMessage','Reservation already exists!');
            }
        }
        $nowDate=Carbon::now();
        if ($reservation->date<$nowDate){
            return back()->with('errorMessage','Date expired');
        }elseif ($reservation->creneaude>=$reservation->creneaua){
                return back()->with('errorMessage','Time expired');
        }elseif(Auth::user()->role=='admin'){
            $reservation->save();
            return redirect('/admin/showReser')->with('message','Reservation successfully added!');
        }else{
            $verif=Room::where('name','=',$reservation->room_name)->value('state');
            if($verif=='speacial'){
                $reservation->satate='wait';
                $reservation->save();
                return back()->with('errorMessage','You need admin approaval');
            }else{
            $reservation->save();
            return redirect('/user/showReser')->with('message','Reservation successfully added!');
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
        $reservation = Reservation::find($id);
        $rooms = Room::all();
        return view('mngReservations.editReservation',['reservation'=>$reservation,'rooms'=>$rooms]);
    }

    public function editAdmin($id)
    {
        $reservation = Reservation::find($id);
        $rooms = Room::all();
        return view('admin.mngReservations.editReservation',['reservation'=>$reservation,'rooms'=>$rooms]);
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
        $request->validate(['id'=>Rule::unique('reservations')->ignore($reservation->id)]);
        $reservation->date = $request->input('date');
        $reservation->creneaude = $request->input('creneaude');
        $reservation->creneaua = $request->input('creneaua');
        $reservation->objective = $request->input('objective');

        foreach($reservations as $reser){
            if($reser->id!=$reservation->id){
                if($reser->room_name==$reservation->room_name && $reser->date==$reservation->date && (
                ($reser->creneaude>=$reservation->creneaude && $reser->creneaua<=$reservation->creneaua)||
                ($reser->creneaude<=$reservation->creneaude && $reser->creneaua>=$reservation->creneaua)|| 
                ($reser->creneaude<$reservation->creneaude && $reser->creneaua>$reservation->creneaude)||
                ($reser->creneaua<$reservation->creneaua && $reser->creneaua>$reservation->creneaua))){
                    return back()->with('errorMessage','Reservation already exists!');
                }
            }
        }
        
        $nowDate=Carbon::now();
       if ($reservation->date<$nowDate){
            return back()->with('errorMessage','Date expired');
         
        }elseif ($reservation->creneaua<$reservation->creneaude){
            return back()->with('errorMessage','Time expired');
        }elseif(Auth::user()->role=='admin'){
            $reservation->save();
            return redirect('/admin/showReser')->with('message','Reservation successfully added!');
        }else{
            if($verif=='speacial'){
            
                return back()->with('errorMessage','You need admin approaval');
            }else{
                $reservation->save();
                return redirect('/user/showReser')->with('message','Reservation successfully added!');
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
        return back()->with('message','Reservation successfully deleted!');
    }

    public function accept($id){
        $reservation=Reservation::find($id);
        $reservation->satate='reserved';
        $reservation->save();
        return redirect('/admin/notifications');
        
    }

    public function refuse($id){
        $reservation=Reservation::find($id);
        $reservation->satate='not-reserved';
        $reservation->save();
        return redirect('/admin/notifications');
        
    }

}
