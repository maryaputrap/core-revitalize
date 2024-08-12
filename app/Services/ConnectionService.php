<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Services;

use App\Models\Connection;

class ConnectionService
{
    /**
     * @param array $inputs
     * @return Connection
     */
    public function create(
        array $inputs,
    ): Connection
    {
        $connection = new Connection();
        $connection->form_port_id = $inputs['form_port_id'];
        $connection->to_port_id = $inputs['to_port_id'];
        $connection->tube = $inputs['tube'];
        $connection->tube_color = $inputs['tube_color'];
        $connection->cable = $inputs['cable'];
        $connection->save();

        return $connection->refresh();
    }
}
