<?php

$servername = "db";
$username = "root";
$password = "root";
$dbname = "shortener_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error . "\n";
}
else echo "Connection successful\n";

$sql = "DELETE FROM links WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully\n";
} else {
    echo "Error deleting record: " . $conn->error . "\n";
}

$conn->close();