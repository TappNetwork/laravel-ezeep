<?php

namespace Tapp\Ezeep\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class EzeepApiClient
{
    private $token;
    private $secret;
    private $url;
    private $organization;
    private $username;
    private $password;

    public function __construct($config, Client $client = null)
    {
        $this->username = $config['client_username'];

        $this->password = $config['client_password'];

        $this->secret = base64_encode("{$config['client_id']}:{$config['client_secret']}");

        $this->token = $this->getAccessToken();

        $this->url = $config['api_url'];

        $this->organization = $this->getOrganization();
    }

    private function getAccessToken()
    {
        $client = new Client([
            'base_uri' => 'https://accounts.ezeep.com',
            'headers' => [
                'Authorization' => "Basic $this->secret",
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $res = $client->request("POST", "/oauth/access_token", [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
                'scope=printjobs:read printjobs:write hosts:read hosts:write printers:read printers:write documents:read documents:write documents:print documents:print:free identity:read identity:write',
            ],
        ]);

        return json_decode($res->getBody()->getContents())->access_token;
    }

    public function getOrganization()
	{
        $client = new Client([
            'base_uri' => "https://accounts.ezeep.com/api/",
            'headers' => [
                'Authorization' => "Basic $this->secret",
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $res = $client->request("GET", "organizations", [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
                'scope=printjobs:read printjobs:write hosts:read hosts:write printers:read printers:write documents:read documents:write documents:print documents:print:free identity:read identity:write',
            ],
        ]);


        dd(json_decode($res->getBody()->getContents()));
	}
}
