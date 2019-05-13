<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Command\PushDataCommand;
use Symfony\Component\Console\Application;

$app = new Application();

$app->add(new PushDataCommand());

$app->run();
