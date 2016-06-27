<?php namespace App\Commands;

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
        // To train the neural network you need to have at least 120 ticks worth of input data with a tick being the minimum
        // resolution that you are dealing with (e.g if you run the scrape command every minute then you have one tick per minute)
        //
        // The reason why this needs at least 120 ticks worth of input data is because it feeds in the first 60 ticks and tests
        // the prediction against the next 60 ticks one tick at a time.
        //
        // So if you have a weeks worth of data stored at a one minute tick resolution the training will create a window of
        // 60 ticks to train the neural network and move the window along one tick, train and repeat until it gets to the most
        // current input tick.
        //
        // The output vector is equal to fifteen ticks in the "future" and essentially just shows a possible trend.
        // This method of input without doing any other manipulation of the input deltas is quite dumb but might provide
        // interesting insight that would otherwise not be visible in the input data.

        // [<--       Training Frame       -->][<-- Prediction Frame -->]
        // [ 1, -1, -1, 1, -1, -1, -1, 1, 1, 1, 1, -1, 1, -1, 1, 1, 1, 1, -1 ]
        // As you train the network on the training frame you can use the known items covered by the prediction frame
        // to test its output. Then move the whole stack to the left by one and repeat until you reach a point where the
        // prediction frame hits the end of the available input data.
    }
}
