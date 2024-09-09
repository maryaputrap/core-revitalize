<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Services;

use App\Actions\Endpoint\GeneratePorts;
use App\Models\Cluster;
use App\Models\Container;
use App\Models\Endpoint;
use App\Models\OptionReference\EndpointType;
use Illuminate\Support\Facades\DB;

class EndpointService
{
    /**
     * @param array $inputs
     * @param string $prefix
     * @param bool $duplicate
     * @return Endpoint
     */
    public function create(
        array $inputs,
        string $prefix = 'PORT',
        bool $duplicate = false,
    ): Endpoint
    {
        $endpoint = new Endpoint();
        $this->saveAttributes($inputs, $endpoint);

        (new GeneratePorts($endpoint, prefix: $prefix, duplicate: $duplicate))->handle();

        return $endpoint->refresh();
    }

    /**
     * @param Endpoint $endpoint
     * @param array $inputs
     * @param string $prefix
     * @param bool $duplicate
     * @return Endpoint
     */
    public function update(
        Endpoint $endpoint,
        array $inputs,
        string $prefix = 'PORT',
        bool $duplicate = false,
    ): Endpoint
    {
        $oldPortTotal = $endpoint->port_total;
        $this->saveAttributes($inputs, $endpoint);

        if ($oldPortTotal !== $inputs['port_total']) {
            (new GeneratePorts(endpoint: $endpoint, regenerate: true, prefix: $prefix, duplicate: $duplicate))->handle();
        }

        return $endpoint->refresh();
    }

    public function delete(Endpoint $endpoint): void
    {
        foreach ($endpoint->ports as $port) {
            $port->fromConnections()->delete();
            $port->toConnections()->delete();
        }

        $endpoint->ports()->delete();
        $endpoint->delete();
    }

    /**
     * @param array $inputs
     * @param Endpoint $endpoint
     * @return void
     */
    private function saveAttributes(array $inputs, Endpoint $endpoint): void
    {
        $endpoint->type_id = EndpointType::hashToId($inputs['type_id']);
        $endpoint->cluster_id = !empty($inputs['cluster_id']) ? Cluster::hashToId($inputs['cluster_id']) : null;
        $endpoint->container_id = !empty($inputs['container_id']) ? Container::hashToId($inputs['container_id']) : null;
        $endpoint->name = $inputs['name'];
        $endpoint->port_total = $inputs['port_total'];
        $endpoint->latitude = $inputs['latitude'] ?? null;
        $endpoint->longitude = $inputs['longitude'] ?? null;

        $endpoint->save();
    }
}
