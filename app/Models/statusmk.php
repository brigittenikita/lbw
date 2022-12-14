<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statusmk extends Model
{
    use HasFactory;
    protected $table = 'statusmks';
    protected $fillable = [
        'status', 'fkMata'
    ];
}
