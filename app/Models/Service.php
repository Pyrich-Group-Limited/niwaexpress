<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employer_id', 'name', 'status'
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function death_claims()
    {
        return $this->hasMany(DeathClaim::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'service_id', 'id');
    }

    /**
     * Get the processing types associated with the service.
     */
    public function processingTypes()
{
    return $this->hasMany(ProcessingType::class, 'service_id', 'id');
}
}
