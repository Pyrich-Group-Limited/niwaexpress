<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeclinedDocument extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'declined_documents';

    public $fillable = [
        'service_id',
        'name',
        'user_id',
    ];


}