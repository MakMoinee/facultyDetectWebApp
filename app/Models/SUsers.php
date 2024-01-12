<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SUsers extends Model
{
    use HasFactory;

    protected $id = 'userID';
    protected $table = 'susers';

    protected $fillable = [
        'userID',
        'email',
        "firstname",
        "middlename",
        "lastname",
        'password',
        'address',
        'birthDate',
        'phoneNumber',
        'userType',
    ];
}
