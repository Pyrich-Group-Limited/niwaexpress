<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    public $fillable=[
        'departure_time',
        'departure_date',
        'departure_state',
        'no_of_passengers',
        'trip_duration',
        'trip_type',
        'price',
        'arrival_time',
        'arrival_day',
        'arrival_state',
        'sub_total',
        'discount',
        'tax',
        'levy',
        'vat',
        'total'
    ];

    public function arrivalbranch(){
        return $this->belongsTo(Branch::class,'arrival_state','id');
    }
    public function departurebranch(){
        return $this->belongsTo(Branch::class,'departure_state','id');
    }
}
