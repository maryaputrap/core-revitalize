<?php

namespace App\Actions\Endpoint;

use App\Abstracts\BaseAction;
use App\Models\Endpoint;
use Override;

class GeneratePorts extends BaseAction
{
    public function __construct(
        public readonly Endpoint $endpoint,
        public readonly bool $regenerate = false,
        public readonly string $prefix = 'PORT',
        public readonly bool $duplicate = false,
    )
    {
        parent::__construct();
    }

    /**
     * @return BaseAction
     */
    #[Override]
    public function rules(): BaseAction
    {
        return $this;
    }

    /**
     * @return Endpoint
     */
    #[Override]
    public function handle(): Endpoint
    {
        if ($this->regenerate) {
            foreach ($this->endpoint->ports as $port) {
                $port->fromConnections()->delete();
                $port->toConnections()->delete();
            }

            $this->endpoint->ports()->delete();
        }

        for ($i = 1; $i <= $this->endpoint->port_total * ($this->duplicate ? 2 : 1); $i++) {
            $actualIteration = $this->duplicate ? ($i > $this->endpoint->port_total ? $i - $this->endpoint->port_total : $i) : $i;
            $num = sprintf("%02d", $actualIteration); // 01, 02, 03, ..., 10, 11, 12, ...

            $data = [
                'name' => "$this->prefix $num",
            ];

            if ($this->duplicate) {
                $data['additional_data'] = [
                    'position' => $i > $this->endpoint->port_total ? 'right' : 'left',
                ];
            }

            $this->endpoint->ports()->create($data);
        }

        return $this->endpoint;
    }
}
