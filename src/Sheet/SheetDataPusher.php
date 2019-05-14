<?php

declare(strict_types=1);

namespace Sheet;

class SheetDataPusher
{
    /**
     * @var \Google_Client
     */
    private $client;

    /**
     * @var SheetDataHandler
     */
    private $dataHandler;

    public function __construct(\Google_Client $client)
    {
        $this->client = $client;
        $this->dataHandler = new SheetDataHandler();
    }

    public function pushDataToSheet(array $data, string $sheetId): void
    {
        $flatData = $this->dataHandler->flattenArray($data);
        $insertRange = $this->dataHandler->calcArraySheetColumnRange($flatData);

        $service = new \Google_Service_Sheets($this->client);

        $service->spreadsheets_values->append(
            $sheetId,
            $insertRange,
            new \Google_Service_Sheets_ValueRange(['values' => [$flatData]]),
            ['valueInputOption' => 'RAW']
        );
    }
}
