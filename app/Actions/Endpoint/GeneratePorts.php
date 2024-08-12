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
    )
    {
        parent::__construct();
    }

    /**
     * @return BaseAction
     */
    #[Override] public function rules(): BaseAction
    {
        return $this;
    }

    /**
     * @return Endpoint
     */
    #[Override] public function handle(): Endpoint
    {
        if ($this->regenerate) {
            $this->endpoint->ports()->delete();
        }

        for ($i = 1; $i <= $this->endpoint->port_total; $i++) {
            $num = sprintf("%02d", $i); // 01, 02, 03, ..., 10, 11, 12, ...
            $this->endpoint->ports()->create([
                'name' => "PORT $num",
            ]);
        }

        return $this->endpoint;
    }
}
