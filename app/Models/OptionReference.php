<?php

namespace App\Models;

use App\Enums\OptionReferenceType;
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
        'type' => OptionReferenceType::class,
        'additional_data' => 'array',
    ];
}
