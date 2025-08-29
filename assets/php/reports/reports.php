<?php
include '../db connect/connect.php';

$sql = "SELECT * FROM reports";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
  echo "Report ID: " . $row['id'] . " | Address: " . $row['address'] . "<br>";
}
