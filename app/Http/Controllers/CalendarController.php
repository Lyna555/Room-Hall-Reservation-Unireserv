<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CalendarController extends Controller
{
    public $src = [
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

    public function searchCalendarAdmin(Request $request){
        if (Auth::user()->role == 'admin') {
            $search = $request->input('search');
            $events = [];
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('satate', '=', 'wait')->count();
            foreach ($this->src as $sr) {
                foreach ($sr['model']::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('objective','like','%'.$search.'%')->get() as $model) {

                    $query = User::where('id', '=', $model->{$sr['user_id']})->value('name');
                    $date = $model->getOriginal($sr['date']);
                    $timestart = $model->getOriginal($sr['creneaude']);
                    $timeend = $model->getOriginal($sr['creneaua']);
                    $crudFieldValue = date('Y-m-d H:i', strtotime("$date $timestart"));
                    $crudFieldValue1 = date('Y-m-d H:i', strtotime("$date $timeend"));


                    if (!$crudFieldValue) {
                        continue;
                    }
                    if ($model->{$sr['satate']} == 'reserved' || $model->{$sr['satate']} == 'reserv-state') {

                        if ($model->{$sr['date']} < Carbon::now()) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$sr['room_name']}
                                    . " " . Carbon::parse($model->{$sr['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$sr['creneaua']})->format('H:i')." ".$model->{$sr['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($sr['route'], $model->id),
                                'color' => '#7fa1bc',
                            ];
                        } elseif (Auth::user()->id == $model->{$sr['user_id']}) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$sr['room_name']}
                                    . " " . Carbon::parse($model->{$sr['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$sr['creneaua']})->format('H:i')." ".$model->{$sr['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($sr['route'], $model->id),
                                'color' => '#f9a35c',
                            ];
                        } else {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$sr['room_name']}
                                    . " " . Carbon::parse($model->{$sr['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$sr['creneaua']})->format('H:i')." ".$model->{$sr['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($sr['route'], $model->id),
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
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('satate', '=', 'wait')->count();
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

    public $rsrc = [
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
            'route'      => '/user/calendar/search',
        ],
    ];

    public function searchCalendarUser(Request $request){
        if (Auth::user()->role == 'prof') {
            $search=$request->input('search');
            $events = [];
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->count();
            foreach ($this->rsrc as $rcr) {
                foreach ($rcr['model']::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('objective','like','%'.$search.'%')->get() as $model) {
                    $query = User::where('id', '=', $model->{$rcr['user_id']})->value('name');
                    $date = $model->getOriginal($rcr['date']);
                    $timestart = $model->getOriginal($rcr['creneaude']);
                    $timeend = $model->getOriginal($rcr['creneaua']);
                    $crudFieldValue = date('Y-m-d H:i', strtotime("$date $timestart"));
                    $crudFieldValue1 = date('Y-m-d H:i', strtotime("$date $timeend"));

                    if (!$crudFieldValue) {
                        continue;
                    }
                    if ($model->{$rcr['satate']} == 'reserved' || $model->{$rcr['satate']} == 'reserv-state') {
                        if ($model->{$rcr['date']} < Carbon::now()) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$rcr['room_name']}
                                    . " " . Carbon::parse($model->{$rcr['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$rcr['creneaua']})->format('H:i')." ".$model->{$rcr['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($rcr['route'], $model->id),
                                'color' => '#7fa1bc',
                            ];
                        } elseif (Auth::user()->id == $model->{$rcr['user_id']}) {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$rcr['room_name']}
                                    . " " . Carbon::parse($model->{$rcr['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$rcr['creneaua']})->format('H:i')." ".$model->{$rcr['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($rcr['route'], $model->id),
                                'color' => '#f9a35c',
                            ];
                        } else {
                            $events[] = [
                                'title' => trim($query . " " . $model->{$rcr['room_name']}
                                    . " " . Carbon::parse($model->{$rcr['creneaude']})->format('H:i') . " - " . Carbon::parse($model->{$rcr['creneaua']})->format('H:i')." ".$model->{$rcr['objective']}),
                                'start' => $crudFieldValue,
                                'end'   => $crudFieldValue1,
                                'url'   => route($rcr['route'], $model->id),
                                'color' => '#92baff',
                            ];
                        }
                    }
                }
            }
            return view('prof.fullcalendar', compact('events', 'count'));
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
            $count = Reservation::where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->where('satate', '=', 'reserv-state')->orWhere('satate', '=', 'reserv-ref')->where('university','=',Auth::user()->university)->where('faculty','=',Auth::user()->faculty)->where('date', '>=', Carbon::now())->where('user_id', '=', Auth::user()->id)->count();
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
            return view('prof.fullcalendar', compact('events', 'count'));
        } else {
            return abort(403);
        }
    }
}
