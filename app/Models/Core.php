<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Core extends Model
{
    use HasFactory;

    /**
     * Get the parent core that owns the port.
     */
    public function parentCore()
    {
        return $this->belongsTo(Port::class, 'port_from_id');
    }

    /**
     * Get the cores for the port.
     */
    public function cores()
    {
        return $this->belongsTo(Port::class, 'port_to_id');
    }
}
