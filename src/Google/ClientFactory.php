<?php

declare(strict_types=1);

namespace Google;

class ClientFactory
{
    /**
     * @var string
     */
    private $credentialsFile;

    public function __construct(string $credentialsFile = null)
    {
        $this->credentialsFile = $credentialsFile;
    }

    public function createGoogleClient(): \Google_Client
    {
        $client = new \Google_Client();

        $client->setAccessType('offline');
        $client->setApplicationName('Php-sheet');
        $client->setAuthConfig($this->loadClientCredentials());
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

        return $client;
    }

    private function loadClientCredentials(): array
    {
        return json_decode(file_get_contents(__DIR__ .'/json-auth.json'), true);
    }
}
