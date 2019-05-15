<?php

declare(strict_types=1);

namespace Google;

class ClientFactory
{
    public function createGoogleClient(array $credentials): \Google_Client
    {
        $client = new \Google_Client();

        $client->setAccessType('offline');
        $client->setApplicationName('Php-sheet');
        $client->setAuthConfig($credentials);
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

        return $client;
    }
}
