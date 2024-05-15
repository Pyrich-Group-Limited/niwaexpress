<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Branch;

class RegistrationFee extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'registration_fees';

    protected $fillable = [
        'service_id', 'amount', 'branch_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
