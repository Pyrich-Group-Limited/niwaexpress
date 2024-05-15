<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EmployerDocuments extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id', 'title', 'file_path', 'payment_status'
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }
}
