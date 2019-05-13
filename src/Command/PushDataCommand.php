<?php

declare(strict_types=1);

namespace Command;

use Google\ClientFactory;
use Sheet\SheetDataPusher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushDataCommand extends Command
{
    public const COMMAND_NAME = 'push:data';

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Reads json data from given file and pushes it to a google sheet')
            ->addArgument('data-file', InputArgument::REQUIRED, 'Path to the data file')
            ->addArgument('sheet-id', InputArgument::REQUIRED, 'Id of the spreadsheet');

        //->addArgument('credential-file', InputArgument::REQUIRED, 'Path to the credential file')
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
         $sheetId = $input->getArgument('sheet-id');
        $pathToDataFile = $input->getArgument('data-file');

        if (!file_exists($pathToDataFile)) {
            $output->writeln(sprintf('<error>File `%s` does not exist</error>', $pathToDataFile));

            return 1;
        }

        $data = json_decode(file_get_contents($pathToDataFile, true), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $output->writeln(sprintf('<error>`%s` must contain valid json</error>', $pathToDataFile));

            return 1;
        }

        $client = (new ClientFactory())->createGoogleClient();

        (new SheetDataPusher($client))->pushDataTosheet($data, $sheetId);

        return 0;
    }
}
