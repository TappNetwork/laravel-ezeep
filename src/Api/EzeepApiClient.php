<?php

namespace Tapp\Ezeep\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class EzeepApiClient implements ApiClient
{
    private $client;

    public function __construct($config, Client $client = null)
    {
        $secret = base64_encode("{$config['client_id']}:{$config['client_secret']}");

        $this->client = $client ?? $this->buildClient($access_token, $config);
    }

    private function buildClient($secret, $config)
    {
        $client = new Client([
            'base_uri' => 'https://accounts.ezeep.com',
            'headers' => [
                'Authorization' => "Basic $secret",
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $res = $client->request("POST", "/oauth/access_token", [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $config['client_username'],
                'password' => $config['client_password'],
                'scope=printjobs:read printjobs:write hosts:read hosts:write printers:read printers:write documents:read documents:write documents:print documents:print:free identity:read identity:write',
            ],
        ]);

        dd($res->getBody()->getContents());
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
