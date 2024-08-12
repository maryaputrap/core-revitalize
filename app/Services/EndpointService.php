<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Services;

use App\Actions\Endpoint\GeneratePorts;
use App\Models\Container;
use App\Models\Endpoint;
use App\Models\OptionReference\EndpointType;

class EndpointService
{
    /**
     * @param array $inputs
     * @return Endpoint
     */
    public function create(
        array $inputs,
    ): Endpoint
    {
        $endpoint = new Endpoint();
        $this->saveAttributes($inputs, $endpoint);

        (new GeneratePorts($endpoint))->handle();

        return $endpoint->refresh();
    }

    /**
     * @param Endpoint $endpoint
     * @param array $inputs
     * @return Endpoint
     */
    public function update(
        Endpoint $endpoint,
        array $inputs,
    ): Endpoint
    {
        $oldPortTotal = $endpoint->port_total;
        $this->saveAttributes($inputs, $endpoint);

        if ($oldPortTotal !== $inputs['port_total']) {
            (new GeneratePorts($endpoint, regenerate: true))->handle();
        }

        return $endpoint->refresh();
    }

    /**
     * @param array $inputs
     * @param Endpoint $endpoint
     * @return void
     */
    private function saveAttributes(array $inputs, Endpoint $endpoint): void
    {
        $endpoint->type_id = EndpointType::hashToId($inputs['type_id']);
        $endpoint->container_id = Container::hashToId($inputs['container_id']);
        $endpoint->code = $inputs['code'];
        $endpoint->name = $inputs['name'];
        $endpoint->port_total = $inputs['port_total'];
        $endpoint->save();
    }
}
