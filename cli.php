<?php

require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Console\Application;

\Forestry\Orm\Storage::set('default', [
    'dsn' => 'sqlite:' . realpath(__DIR__ . '/datastore') . DIRECTORY_SEPARATOR . 'stocks.db',
]);

$application = new Application();
$application->add(new \App\Commands\InitDatabaseCommand());
$application->add(new \App\Commands\ScrapeCommand());
$application->run();
