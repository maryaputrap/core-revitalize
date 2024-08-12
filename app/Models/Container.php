<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Container extends Model
{
    use SoftDeletes;
//    use HasFactory;
    use HashableId;

    protected $fillable = [
        'cluster_id',
        'code',
        'name',
        'latitude',
        'longitude',
    ];

    protected $appends = [
        'hash',
    ];

    protected $hidden = [
        'id',
        'cluster_id',
    ];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }

    public function endpoints()
    {
        return $this->hasMany(Endpoint::class);
    }
}
