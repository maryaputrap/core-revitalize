<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'latitude',
        'longitude',
    ];

    public function hardwares()
    {
        return $this->hasMany(Hardware::class);
    }
}
