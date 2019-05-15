<?php

declare(strict_types=1);

namespace Command;

use Google\ClientFactory;
use Sheet\SheetDataFormatter;
use Sheet\SheetDataPusher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PushDataCommand extends Command
{
    public const COMMAND_NAME = 'push:data';

    private const ENV_SHEET_ID = 'GOOGLE_SHEET_ID';
    private const ENV_SHEET_AUTH = 'GOOGLE_SHEET_AUTH';

    /**
     * @var OutputInterface
     */
    private $output;

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);

        $this->setDescription('Reads json data from given file and pushes it to a google sheet');

        $this->addArgument('path', InputArgument::REQUIRED, 'Path to the data file');

        $this->addOption('sheet', 's', InputOption::VALUE_OPTIONAL, 'Id of the spreadsheet');
        $this->addOption('credentials', 'c', InputOption::VALUE_OPTIONAL, 'Path to a credentials file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;

        $path = $input->getArgument('path');
        $sheetId = $input->getOption('sheet');
        $credentialsPath = $input->getOption('credentials');

        $data = $this->loadData($path);

        $sheetId = $sheetId ?? getenv(self::ENV_SHEET_ID);

        $credentials = $credentialsPath ?
            $this->loadData($credentialsPath):
            $this->decodeJson(getenv(self::ENV_SHEET_AUTH), self::ENV_SHEET_AUTH);

        if (!$this->push($data, $sheetId, $credentials)) {
            $this->output->writeln(sprintf('<error>Failed to push `%s` \'s data to the sheet.</error>', $path));
            return 1;
        }

        $this->output->writeln(sprintf('<info>`%s` data is pushed to the sheet.</info>', $path));

        return 0;
    }

    private function push(array $data, string $sheetId, array $credentials): bool
    {
        $client = (new ClientFactory())->createGoogleClient($credentials);

        return (new SheetDataPusher($client, new SheetDataFormatter()))->pushDataTosheet($data, $sheetId);
    }

    private function loadData(string $path): ?array
    {
        if (!file_exists($path)) {
            $this->output->writeln(sprintf('<error>File `%s` does not exist</error>', $path));

            return null;
        }

        return $this->decodeJson(file_get_contents($path, true), $path);
    }

    private function decodeJson(string $jsonString, string $name): ?array
    {
        $data = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->output->writeln(sprintf('<error>`%s` must contain valid json</error>', $name));

            return null;
        }

        return $data;
    }
}
