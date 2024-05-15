<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationFormFee extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'application_form_fees';

    protected $fillable = [
        'service_id', 'amount'
    ];

    
}
