<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = "branches";

    // public function arrival(){
    //     return $this->hasMany(Booking::class,'arrival_state');
    // }
    // public function departure(){
    //     return $this->hasMany(Booking::class,'departure_state');
    // }

}
