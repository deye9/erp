<?php

namespace Interfaces\Console;

use Illuminate\Console\Command;
use PDO;
use PDOException;

class DatabaseCreateCommand extends Command
{
    protected $pdo;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a new database';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'db:create {tenantID}';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tenantID = $this->argument('tenantID');

        if (!$tenantID) {
            $this->info('Skipping creation of database as database ID is empty');
            return;
        }

        try {
            $this->getPDOConnection();

            $res = $this->createDbUser($tenantID);

            if ($res === 0) {
                $res = $this->createDB($tenantID);
            }

            $this->info(sprintf('Successfully created %s database', $tenantID));
        } catch (PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $tenantID, $exception->getMessage()));
        }
    }

    private function createDB($tenantID)
    {
        return $this->pdo->exec("CREATE DATABASE \"$tenantID\" WITH OWNER = " . env('DB_USERNAME') .
            " ENCODING = 'UTF8' LC_COLLATE = 'C' LC_CTYPE = 'C' TABLESPACE = pg_default CONNECTION LIMIT = -1;");
    }

    private function createDbUser($tenantID)
    {
        return $this->pdo->exec("CREATE USER \"$tenantID\" WITH LOGIN SUPERUSER INHERIT CREATEDB CREATEROLE REPLICATION;
        GRANT andelatsm TO \"$tenantID\" WITH ADMIN OPTION;");
    }

    /**
     * @param  string $host
     * @param  integer $port
     * @param  string $username
     * @param  string $password
     * @return PDO
     */
    private function getPDOConnection(): void
    {
        // connect to the postgresql database
        $conStr = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            env('DB_HOST'),
            env('DB_PORT'),
            env('DB_DATABASE'),
            env('DB_USERNAME'),
            env('DB_PASSWORD')
        );

        $this->pdo = new \PDO($conStr);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}
