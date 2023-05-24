<?php
$servername = "db";
$username = "root";
$password = "root";
$dbname = "shortener_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";





$limit = 1;
$offset = 1;

$sql = "SELECT * FROM links LIMIT " . $limit . " OFFSET " . $offset;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Source: " . $row["source"] . " - Short: " . $row["short"]. "\n";
    }
} else {
    echo "0 results\n";
}
$conn->close();