<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "agriculture_db");

if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Connection failed"]);
  exit;
}

$google_id = $_GET["google_id"];
$result = $conn->query("SELECT * FROM users WHERE google_id = '$google_id'");

if ($result && $row = $result->fetch_assoc()) {
  echo json_encode(["status" => "success", "user" => $row]);
} else {
  echo json_encode(["status" => "error", "message" => "User not found"]);
}
$conn->close();
?>
