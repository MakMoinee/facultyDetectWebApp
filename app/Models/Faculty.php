<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $id = 'facultyID';
    protected $table = 'faculty';

    protected $fillable = [
        'facultyID',
        'facultyName',
        "imagePath",
        "status",
        "modelPath",
        "approver",
    ];
}
