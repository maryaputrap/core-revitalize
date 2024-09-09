<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Veelasky\LaravelHashId\Eloquent\HashableId;

/**
 * @property mixed $toConnections
 * @property bool $is_connected
 * @property mixed $toPorts
 */
class Port extends Model
{
    use HasFactory;
    use HashableId;

    protected $fillable = [
        'name',
        'form_port_id',
        'to_port_id',
        'tube',
        'tube_color',
        'cable',
        'additional_data',
    ];

    protected $appends = [
        'hash'
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'is_connected' => 'boolean',
        'additional_data' => 'array',
    ];

    public function endpoint(): BelongsTo
    {
        return $this->belongsTo(Endpoint::class);
    }

    public function toPorts(): BelongsToMany
    {
        return $this->belongsToMany(Port::class, 'connections', 'from_port_id', 'to_port_id');
    }

    public function fromPorts(): BelongsToMany
    {
        return $this->belongsToMany(Port::class, 'connections', 'to_port_id', 'from_port_id');
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
