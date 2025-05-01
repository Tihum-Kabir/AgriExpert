<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "agriculture_db");

if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Database connection failed"]);
  exit;
}

$result = $conn->query("SELECT * FROM soil_data ORDER BY timestamp DESC");

$rows = [];
while ($row = $result->fetch_assoc()) {
  $rows[] = $row;
}

echo json_encode(["status" => "success", "data" => $rows]);

$conn->close();
?>
