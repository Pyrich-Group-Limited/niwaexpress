<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Epromoterservices extends Model
{
    use HasFactory;
    public $fillable = [
        'applicant_code',
        'service_id',
        'areaoffice_id'

    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'areaoffice_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
    public function applicant()
    {
        return  $this->belongsTo(Employer::class, 'applicant_code', 'id');
    }
}
