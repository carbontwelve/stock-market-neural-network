<?php namespace App\Commands;

use Forestry\Orm\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitDatabaseCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:init')
            ->setDescription('Init data store');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Storage::get('default')->query("CREATE TABLE IF NOT EXISTS stocks(id INTEGER PRIMARY KEY, created_at TEXT, symbol TEXT, last_value NUMERIC, last_value_delta NUMERIC)");
    }
}
