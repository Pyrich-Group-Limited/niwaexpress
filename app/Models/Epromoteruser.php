<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Epromoteruser extends Model
{
    use HasFactory;

    public $fillable = [
        'promotercode',
        'first_name',
        'other_name',
        'phone_number',
        'email',
        'password',
        'password_confirmation',
        'office_id',
        'service_id',
        'status',

    ];


    public function branch(){
        $this->belongsTo(Branch::class,'office_id','id');
    }

    public function service(){
        $this->belongsTo(Service::class,'service_id','id');
    }


    ///atp you ought to do a relationship btw epromoter and employers table, using promotercode as the foreign


}
