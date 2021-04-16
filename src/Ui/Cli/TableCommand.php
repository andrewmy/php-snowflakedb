<?php

declare(strict_types=1);

namespace App\Ui\Cli;

use App\Infrastructure\SnowflakeConnector;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TableCommand extends Command
{
    protected static $defaultName = 'app:table';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dbh = (new SnowflakeConnector())->connect();

        $table = new Table($output);
        $table->setHeaders(
            ['External Order', 'Date', 'Corrected date'],
        );

        $sth = $dbh->query(
            'select * from PROD_ANALYTICS.SALES_CHANNELS.SHOPIFY_ORDERS '
            . 'order by CORRECTED_CREATED_DATE desc limit 14',
        );
        while ($row = $sth->fetch()) {
            $table->addRow([
                $row['EXTERNAL_ORDER_ID'],
                $row['ORIGINAL_CREATED_AT'],
                $row['CORRECTED_CREATED_DATE'],
            ]);
        }
        $dbh = null;

        $table->render();

        return self::SUCCESS;
    }
}