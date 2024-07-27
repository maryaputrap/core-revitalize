<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_port_id',
        'to_port_id',
        'tube',
        'tube_color',
        'cable',
    ];
}
