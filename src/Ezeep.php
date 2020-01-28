<?php

namespace Tapp\Ezeep;

class Ezeep
{
    private $api;

    public function __construct($client)
    {
        $this->api = $client;
    }

    public function hello()
    {
        return 'hello';
    }
}
