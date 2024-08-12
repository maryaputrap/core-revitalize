<?php

namespace App\Models\OptionReference;

use App\Enums\OptionReference\OptionReferenceType;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class OptionReference extends Model
{
    use HashableId;

    protected $fillable = [
        'type',
        'code',
        'content',
        'additional_data',
    ];

    protected $hidden = [
        'id',
        'deleted_at',
        'deleted_by',
        'restore_at',
        'restore_by',
    ];

    protected $appends = [
        'hash',
    ];

    protected $casts = [
        'type' => OptionReferenceType::class,
        'additional_data' => 'array',
    ];
}
