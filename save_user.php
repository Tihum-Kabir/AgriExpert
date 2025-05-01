<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

$conn = new mysqli("localhost", "root", "", "agriculture_db");

if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "DB connection failed"]);
  exit;
}

// Insert or update the user profile
$stmt = $conn->prepare("INSERT INTO users (google_id, username, name, email, phone)
  VALUES (?, ?, ?, ?, ?)
  ON DUPLICATE KEY UPDATE name=VALUES(name), email=VALUES(email), phone=VALUES(phone)");

$stmt->bind_param("sssss", $data["google_id"], $data["username"], $data["name"], $data["email"], $data["phone"]);

if ($stmt->execute()) {
  echo json_encode(["status" => "success"]);
} else {
  echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
