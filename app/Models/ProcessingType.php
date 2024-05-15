<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessingType extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'processing_types';

    protected $fillable = [
        'service_id', 'name'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
