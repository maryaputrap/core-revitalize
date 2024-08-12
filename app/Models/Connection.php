<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $form_port_id
 * @property mixed $to_port_id
 * @property mixed $cable
 * @property mixed $tube_color
 * @property mixed $tube
 */
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

    public function fromPort()
    {
        return $this->belongsTo(Port::class, 'from_port_id');
    }

    public function toPort()
    {
        return $this->belongsTo(Port::class, 'to_port_id');
    }
}
