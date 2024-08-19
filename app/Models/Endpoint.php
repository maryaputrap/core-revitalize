<?php

namespace App\Models;

use App\Models\OptionReference\EndpointType;
use App\Models\OptionReference\OptionReference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use Veelasky\LaravelHashId\Eloquent\HashableId;

/**
 * @property mixed $type_id
 * @property int|mixed|null $container_id
 * @property mixed $code
 * @property mixed $name
 * @property mixed $port_total
 * @property Collection<Port> $ports
 */
class Endpoint extends Model
{
//    use HasFactory;
    use HashableId;

    protected $fillable = [
        'type_id',
        'container_id',
        'code',
        'name',
        'port_total',
    ];

    protected $appends = [
        'hash',
    ];

    protected $hidden = [
        'id',
        'type_id',
        'container_id',
    ];

    protected $with = ['type'];

    public function type(): belongsTo
    {
        return $this->belongsTo(EndpointType::class, 'type_id');
    }

    public function container(): belongsTo
    {
        return $this->belongsTo(Container::class);
    }

    /**
     * @return HasMany
     */
    public function ports(): HasMany
    {
        return $this->hasMany(Port::class, 'endpoint_id');
    }

    /**
     * @return Builder
     */
    public function connections(): Builder
    {
        return Connection::query()
            ->whereHas('fromPort', function ($query) {
                $query->where('endpoint_id', $this->id);
            })
            ->orWhereHas('toPort', function ($query) {
                $query->where('endpoint_id', $this->id);
            });
    }
}
