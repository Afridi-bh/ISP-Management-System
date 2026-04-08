<?php

namespace App\Classes;

use Exception;
use RouterOS\Client;
use RouterOS\Query;

class Mikrotik
{
    protected $client;

    public function __construct()
    {
        $this->client = $this->checkConnection();
    }

    public function checkConnection()
    {
        try {
            $client = new Client([
                'host' => get_setting('router_ip'),
                'user' => get_setting('router_username'),
                'pass' => get_setting('router_password') ?: ''
            ]);

            // Test connection by running a simple query
            $client->query(new Query('/system/resource/print'))->read();

            return $client;
        } catch (Exception $exception) {
            // Return a dummy client that mimics the real Client behavior
            return new class {
                public function query($query)
                {
                    // Return self for method chaining
                    return $this;
                }
                public function read()
                {
                    // Return fake data or empty array
                    return [
                        ['uptime' => '0s', 'version' => 'mock', 'cpu-load' => 0],
                    ];
                }
            };
        }
    }

    public function getClient()
    {
        return $this->client;
    }
}
