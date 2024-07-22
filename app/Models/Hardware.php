<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hardware extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hardwares';
    protected $fillable = [
        'code',
        'name',
        'port_total',
        'container_id',
    ];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function ports()
    {
        return $this->hasMany(Port::class);
    }
}
