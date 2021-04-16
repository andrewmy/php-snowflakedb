<?php

declare(strict_types=1);

namespace App\Infrastructure;

use PDO;

final class SnowflakeConnector
{
    public function connect(): PDO
    {
        $dbh = new PDO(
            'snowflake:account=' . $_ENV['SNOWFLAKE_ACCOUNT'],
            $_ENV['SNOWFLAKE_USER'],
            $_ENV['SNOWFLAKE_PASSWORD'],
        );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbh;
    }
}