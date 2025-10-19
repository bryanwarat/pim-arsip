<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingMail extends Model
{
    protected $fillable = [
        'mail_type_id', 
        'classification_id', 
        'mail_number',
        'mail_date',
        'origin',
        'destination',
        'subject',
        'file_path',
        'created_by',
    ];
}
