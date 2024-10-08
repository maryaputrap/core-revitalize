<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Veelasky\LaravelHashId\Eloquent\HashableId;

/**
 * @property Collection<Container> $containers
 */
class Cluster extends Model
{
    //    use HasFactory;
    use HashableId;

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
    ];

    protected $appends = [
        'hash',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double'
    ];

    public function containers(): HasMany
    {
        return $this->hasMany(Container::class);
    }

    public function endpoints(): HasMany
    {
        return $this->hasMany(Endpoint::class);
    }
}
