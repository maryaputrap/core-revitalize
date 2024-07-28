<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Endpoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'container_id',
        'name',
        'latitude',
        'longitude',
    ];

    public function type(): belongsTo
    {
        return $this->belongsTo(OptionReference::class, 'type_id');
    }
}
