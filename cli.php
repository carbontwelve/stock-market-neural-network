<?php

date_default_timezone_set("UTC");

require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Console\Application;

\Forestry\Orm\Storage::set('default', [
    'dsn' => 'sqlite:' . realpath(__DIR__ . '/datastore') . DIRECTORY_SEPARATOR . 'stocks.db',
]);

$application = new Application();
$application->addCommands([
    new \App\Commands\InitDatabaseCommand(),
    new \App\Commands\ScrapeCommand(),
    new \App\Commands\NeuralNetworkForecastCommand(),
    new \App\Commands\NeuralNetworkTrainCommand(),
    new \App\Commands\StatusCommand()
]);
$application->run();
