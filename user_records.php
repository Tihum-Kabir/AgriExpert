<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "agriculture_db");

if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Connection failed"]);
  exit;
}

$userId = $_GET["userId"] ?? "";

if (empty($userId)) {
  echo json_encode(["status" => "error", "message" => "Missing userId"]);
  exit;
}

$sql = "SELECT soilPh, moisture, timestamp AS created_at FROM soil_data WHERE userId = ? ORDER BY timestamp ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();

$result = $stmt->get_result();
$records = [];

while ($row = $result->fetch_assoc()) {
  $records[] = $row;
}

echo json_encode([
  "status" => "success",
  "records" => $records
]);

$stmt->close();
$conn->close();
?>
