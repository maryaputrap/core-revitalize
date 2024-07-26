<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionReference extends Model
{
    protected $fillable = [
        'type',
        'code',
        'content',
        'additional_data',
    ];

    protected $casts = [
        'additional_data' => 'array',
    ];
}
