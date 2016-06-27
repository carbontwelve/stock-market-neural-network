<?php namespace App\Commands;

use App\Stock;
use Forestry\Orm\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('stock:status')
            ->setDescription('Init data store');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        if (!$storage = Storage::get('default')->query('SELECT symbol, COUNT(id) as c FROM stocks GROUP BY symbol')){
            // error
            exit();
        }else{
            $symbols = [];
            while($data = $storage->fetch(\PDO::FETCH_ASSOC)) {
                $symbols[$data['symbol']] = $data['c'];
            }
        }

        $table = new Table($output);

        $table->setHeaders(['Symbol', 'Total Ticks', 'Last Ticked', 'Last Value']);

        foreach($symbols as $symbol => $ticks) {

            if ($ticks > 0) {
                $stock = new Stock();
                $stock = $stock->query('SELECT * FROM ' . $stock->getTable() . ' WHERE symbol = "' . $symbol . '" ORDER BY id DESC LIMIT 1');
                $stock = $stock[0];

                $table->addRow([
                    $symbol,
                    $ticks,
                    date('Y-m-d H:i:s', $stock->created_at),
                    $stock->last_value
                ]);
            }
        }

        $table->render();
    }
}
