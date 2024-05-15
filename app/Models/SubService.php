<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'service_id', 'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'service_id', 'id');
    }
}
