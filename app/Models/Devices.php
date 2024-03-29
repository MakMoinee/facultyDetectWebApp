<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;

    protected $id = 'deviceID';
    protected $table = 'devices';

    protected $fillable = [
        'deviceID',
        'room',
        "ip",
        "status",
        "created_at",
        "updated_at",
    ];
}
