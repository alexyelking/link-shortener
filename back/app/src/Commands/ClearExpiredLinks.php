<?php

namespace Shortener\Commands;

use Shortener\Infrastructure\DatabaseConnectionReturner;

class ClearExpiredLinks
{
    public function run(): void
    {
        $databaseConnection = new DatabaseConnectionReturner();
        $database = $databaseConnection->connect();

        $sql = "DELETE FROM links WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)";
        if ($database->query($sql) === TRUE) {
            echo "Record deleted successfully\n";
        } else {
            echo "Error deleting record: " . $database->error . "\n";
        }
        $database->close();
    }
}