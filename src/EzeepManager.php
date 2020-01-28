<?php

namespace Tapp\Ezeep;

use Tapp\Ezeep\Api\EzeepApiClient;

class EzeepManager
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    protected function resolve()
    {
        $config = $this->app['config']['ezeep'];

        if ($config) {
            return $this->createEzeep($config);
        }
    }

    protected function createEzeep($config)
    {
        $client = new EzeepApiClient($config);

        return new Ezeep($client);
    }

    public function __call($method, $parameters)
    {
        return $this->resolve()->$method(...$parameters);
    }
}
