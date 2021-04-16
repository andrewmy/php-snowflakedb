<?php

declare(strict_types=1);

namespace App\Ui\Cli;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConnectCommand extends Command
{
    protected static $defaultName = 'app:connect';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dbh = new PDO(
            'snowflake:account=' . $_ENV['SNOWFLAKE_ACCOUNT'],
            $_ENV['SNOWFLAKE_USER'],
            $_ENV['SNOWFLAKE_PASSWORD'],
        );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $output->writeln('Connected');

        $sth = $dbh->query("select 1234");
        while ($row=$sth->fetch(PDO::FETCH_NUM)) {
            $output->writeln("RESULT: {$row[0]}");
        }
        $dbh = null;

        $output->writeln('OK');

        return self::SUCCESS;
    }
}