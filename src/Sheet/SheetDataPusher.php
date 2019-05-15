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
     * @var SheetDataFormatter
     */
    private $dataFormatter;

    public function __construct(\Google_Client $client, SheetDataFormatter $dataFormatter)
    {
        $this->client = $client;
        $this->dataFormatter = $dataFormatter;
    }

    public function pushDataToSheet(array $data, string $sheetId): bool
    {
        $flatData = $this->dataFormatter->flattenArray($data);
        $insertRange = $this->dataFormatter->calcArraySheetColumnRange($flatData);

        $service = new \Google_Service_Sheets($this->client);

        $response =$service->spreadsheets_values->append(
            $sheetId,
            $insertRange,
            new \Google_Service_Sheets_ValueRange(['values' => [$flatData]]),
            ['valueInputOption' => 'RAW']
        );

        return $response->getUpdates()->getUpdatedRows() > 0;
    }
}
