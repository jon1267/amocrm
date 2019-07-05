<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'contact_id', 'name', 'responsible_user_id',
        'created_by', 'amo_created_time'
    ];
}
