<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Port extends Model
{
    use HasFactory;
    use HashableId;

    protected $fillable = [
        'form_port_id',
        'to_port_id',
        'tube',
        'tube_color',
        'cable'
    ];

    protected $appends = [
        'hash'
    ];

    protected $hidden = [
        'id',
    ];

    public function endpoint(): BelongsTo
    {
        return $this->belongsTo(Endpoint::class);
    }

    public function fromConnections()
    {
        return $this->hasMany(Connection::class, 'from_port_id');
    }

    public function toConnections()
    {
        return $this->hasMany(Connection::class, 'to_port_id');
    }
}
