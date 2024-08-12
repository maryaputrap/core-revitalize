<?php

namespace App\Models\OptionReference;

use App\Enums\OptionReference\OptionReferenceType;
use Illuminate\Database\Eloquent\Builder;

class EndpointType extends OptionReference
{
    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('scope_table_where_type_is_endpoint_type', function (Builder $builder) {
            $builder->where('type', '=', OptionReferenceType::ENDPOINT());
        });
    }
}
