<?php

namespace Tapp\Ezeep\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class EzeepApiClient implements ApiClient
{
    private $client;

    public function __construct($client_id, $client_secret, Client $client = null)
    {
        $access_token = "";

        $this->client = $client ?? $this->buildClient($access_token);
    }

    private function buildClient($access_token)
    {
        return new Client([
            'base_uri' => '',
            'headers' => [
                'Authorization' => "",
                'content-type' => 'application/json',
            ],
        ]);
    }

    public function get(?string $id = null)
    {
        $url = $this->getEndpointUrl($id);

        return $this->decodeResponse($this->client->get($url));
    }

    public function post($contents = null)
    {
        $url = $this->getEndpointUrl();

        $params = ['json' => ['fields' => (object) $contents]];

        return $this->decodeResponse($this->client->post($url, $params));
    }

    public function put(string $id, $contents = null)
    {
        $url = $this->getEndpointUrl($id);

        $params = ['json' => ['fields' => (object) $contents]];

        return $this->decodeResponse($this->client->put($url, $params));
    }

    public function patch(string $id, $contents = null)
    {
        $url = $this->getEndpointUrl($id);

        $params = ['json' => ['fields' => (object) $contents]];

        return $this->decodeResponse($this->client->patch($url, $params));
    }

    public function delete(string $id)
    {
        $url = $this->getEndpointUrl($id);

        return $this->decodeResponse($this->client->delete($url));
    }

    public function responseToJson($response)
    {
        $body = (string) $response->getBody();

        return $body;
    }

    public function responseToCollection($response)
    {
        $body = (string) $response->getBody();

        if ($body === '') {
            return collect([]);
        }

        $object = json_decode($body);

        return isset($object->records) ? collect($object->records) : $object;
    }

    public function decodeResponse($response)
    {
        $body = (string) $response->getBody();

        if ($body === '') {
            return [];
        }

        return json_decode($body, true);
    }

    protected function getEndpointUrl(?string $id = null): string
    {
        $url = '';

        return $url;
    }
}
