<?php

namespace App\Models;

use App\Traits\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceApplicationDocument extends Model
{
    protected $table = 'service_applications_documents';

    protected $fillable = [
        'service_application_id', 'name', 'path'
    ];

    use HasFactory;
    use Approval;
}
