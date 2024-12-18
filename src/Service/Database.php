<?php
declare(strict_types=1);

namespace App\Service;

use PgSql\Connection;

final class Database
{
    private Connection $connection;

    public function __construct(
        private readonly string $host,
        private readonly int $port,
        private readonly string $dbName,
        private readonly string $username,
        private readonly string $password
    ) {}

    public function connect(): void
    {
        $connectionString = sprintf(
            "host=%s port=%u dbname=%s user=%s password=%s",
            $this->host, $this->port, $this->dbName, $this->username, $this->password
        );

        $this->connection = pg_connect($connectionString);

        if (!$this->connection) {
            die("Błąd połączenia z bazą danych: " . pg_last_error());
        }
    }

    public function query($sql): array
    {
        $result = pg_query($this->connection, $sql);

        if (!$result) {
            die("Błąd zapytania: " . pg_last_error());
        }

        return pg_fetch_all($result);
    }

    public function insert($sql): int
    {
        $result = pg_query($this->connection, $sql);

        if (!$result) {
            die("Błąd zapytania INSERT: " . pg_last_error());
        }

        return pg_affected_rows($result);
    }

    public function close(): void
    {
        pg_close($this->connection);
    }
}