<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    use HasFactory;

    protected $id = 'resultID';
    protected $table = 'results';

    protected $fillable = [
        'resultID',
        'facultyID',
        "age",
        "pregnancyStage",
        "numberOfFetus",
        'healthStatus',
        'imagePath',
        "created_at"
    ];
}
