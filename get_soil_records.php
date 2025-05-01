<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "agriculture_db");

if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Connection failed"]);
  exit;
}

$userId = $_GET["userId"];
$result = $conn->query("SELECT * FROM soil_data WHERE userId = '$userId' ORDER BY timestamp DESC");

$records = [];
while ($row = $result->fetch_assoc()) {
  $records[] = $row;
}

echo json_encode(["status" => "success", "records" => $records]);
$conn->close();
?>
