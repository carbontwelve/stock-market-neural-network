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

        $table->setHeaders(['Symbol', 'Total Ticks', 'First Ticked', 'Last Ticked', 'Last Value']);

        foreach($symbols as $symbol => $ticks) {

            if ($ticks > 0) {
                $last = new Stock();
                $last = $last->query('SELECT * FROM ' . $last->getTable() . ' WHERE symbol = "' . $symbol . '" ORDER BY id DESC LIMIT 1');
                $last = $last[0];

                $first = new Stock();
                $first = $last->query('SELECT * FROM ' . $first->getTable() . ' WHERE symbol = "' . $symbol . '" ORDER BY id ASC LIMIT 1');
                $first = $first[0];

                $table->addRow([
                    $symbol,
                    $ticks,
                    date('Y-m-d H:i:s', $first->created_at),
                    date('Y-m-d H:i:s', $last->created_at),
                    $last->last_value
                ]);
            }
        }
        $table->render();
    }
}
