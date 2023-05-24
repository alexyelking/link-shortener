<?php
require_once 'db.php';
$db = new MysqliDatabase();
$conn = $db->connect();


$limit = empty($_GET['limit']) ? 100 : $_GET['limit'];
$offset = $_GET['offset'] ?: 0;

$sql = "SELECT * FROM links LIMIT ? OFFSET ?";
$statement = $conn->prepare($sql);
$statement->bind_param("ii", $limit, $offset);
$statement->execute();
$result = $statement->get_result();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Source: " . $row["source"] . " - Short: " . $row["short"]. "\n";
    }
} else {
    echo "0 results\n";
}
$conn->close();