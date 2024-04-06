<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'datetime_of_service',
        'deadline_date',
        'comment',
        'item_id',
    ];
}
