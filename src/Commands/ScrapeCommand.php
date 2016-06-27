<?php namespace App\Commands;

use App\Stock;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use App\Library\YahooFinanceScraper;

class ScrapeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('stock:scrape')
            ->setDescription('Scrape the input stocks')
            ->addArgument(
                'stock',
                InputArgument::IS_ARRAY,
                'Which stocks'
            )
            ->addOption(
               'no-store',
               null,
               InputOption::VALUE_NONE,
               'Set if we need to store this value'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stocks = $input->getArgument('stock');

        if(count($stocks) < 1){
            $output->writeln('<error>[!]</error> You need to provide at least one stock for input');
            exit();
        }

        $scraper = new YahooFinanceScraper();

        if (! $results = $scraper->getCurrentQuote($stocks)){
            $output->writeln('<error>[!]</error> Sorry there was an error scraping the results.');
            exit();
        }

        foreach ($results as $symbol => $value) {

            $lastValue = new Stock();
            if ($lastValue = $lastValue->query('SELECT * FROM ' . $lastValue::$table . ' WHERE symbol = "'. $symbol .'" ORDER BY id DESC LIMIT 1')) {
                $lastValue = $lastValue[0];
            }else{
                $lastValue = new Stock();
                $lastValue->last_value = 0;
            }

            if (!is_null($value)) {

                if($lastValue->last_value == 0) {
                    $lastValueDelta = $value;
                }else{
                    $lastValueDelta = round($lastValue->last_value - $value, 2);
                }
                
                if ($output->isVerbose()){
                    $output->writeln(time() . ' ' . $symbol . ' = ' . $value . ' (Delta: '. $lastValueDelta .' ['. ($lastValueDelta < 0 ? '---' : '+++') .'])');
                }

                if (!$input->getOption('no-store')) {
                    $stock = new Stock();
                    $stock->created_at = time();
                    $stock->symbol = $symbol;
                    $stock->last_value = $value;
                    $stock->last_value_delta = $lastValueDelta;
                    $stock->save();
                }
            }
        }
    }
}
