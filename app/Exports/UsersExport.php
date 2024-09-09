<?php

namespace App\Exports;

use App\Enums\OptionReference\EndpointType;
use App\Models\Connection;
use App\Models\Endpoint;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    protected string $filter;

    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }

    /**
    * @return Collection
    */
    public function collection()
    {
        $data = collect();
        $parentPort = null;

        /** @var Endpoint $beforeEndpoint */
        $beforeEndpoint = Endpoint::query()->whereHas('type', function ($query) {
            $query->where('code', EndpointType::ODF());
        })->when($this->filter, function ($query) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($this->filter).'%']);
        })->first();

        if (!$beforeEndpoint) {
            return $data;
        }

        $connection = Connection::query()
            ->with(['fromPort.endpoint', 'toPort'])
            ->whereHas('toPort', function ($query) use ($beforeEndpoint) {
                $query->where('endpoint_id', $beforeEndpoint->id);
            })->first();

        if (!$connection) {
            return $data;
        }

        $parentPort = $connection->fromPort;

        $data->push([
            'type' => EndpointType::ODF(),
            'name' => $beforeEndpoint->name,
            'latitude' => $beforeEndpoint->latitude,
            'longitude' => $beforeEndpoint->longitude,
            'core' => $connection ? $connection->fromPort->name . '/' . $connection->toPort->name : null,
        ]);

        while ($parentPort) {

            $endpoint = $parentPort->endpoint;

            $connection = Connection::query()
                ->with(['fromPort.endpoint', 'toPort'])
                ->whereHas('toPort', function ($query) use ($parentPort) {
                    $query->where('id', $parentPort->id);
                })->first();

            $data->push([
                'type' => $endpoint->type->code,
                'name' => $endpoint->name,
                'latitude' => $endpoint->latitude,
                'longitude' => $endpoint->longitude,
                'core' => $connection ? $connection->fromPort->name . '/' . $connection->toPort->name : $parentPort->name,
            ]);

            if (!$connection) {
                break;
            }

            $parentPort = $connection->fromPort;
        }

        $data = $data->reverse()->values()->map(function ($endpoint, $key) {
            return array_merge(['no' => $key + 1], $endpoint);
        });

        $data->prepend([
            'no' => 'No',
            'type' => 'Type',
            'name' => 'Name',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'core' => 'Core Connection',
        ]);

        return $data;
    }
}
