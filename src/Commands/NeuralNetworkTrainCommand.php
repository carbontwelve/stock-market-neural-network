<?php namespace App\Commands;

use Forestry\Orm\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NeuralNetworkTrainCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('stock:train')
            ->setDescription('Train the Neural Networks using available data.');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }
}
