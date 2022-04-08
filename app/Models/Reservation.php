<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;
    public $table = 'reservations';


    protected $fillable = [
        'id',
        'room_id',
        'date',
        'creneaude',
        'creneaua',
    ];
}
