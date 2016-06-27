<?php namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NeuralNetworkForecastCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('stock:forecast')
            ->setDescription('Return the Neural Networks forecast for data available');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }
}
