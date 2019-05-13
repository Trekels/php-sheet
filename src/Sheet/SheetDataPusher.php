<?php

declare(strict_types=1);

namespace Sheet;

class SheetDataPusher
{
    /**
     * @var \Google_Client
     */
    private $client;

    public function __construct(\Google_Client $client)
    {
        $this->client = $client;
    }

    public function pushDataToSheet(array $data, string $sheetId): void
    {
        $service = new \Google_Service_Sheets($this->client);

        // TODO cal sheet insert range.

        $body   = new \Google_Service_Sheets_ValueRange(['values' => $data]);

        $result = $service->spreadsheets_values->append($sheetId, 'A1:C1', $body, ['valueInputOption' => 'RAW']);
    }
}
