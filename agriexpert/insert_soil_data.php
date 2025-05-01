<?php
header("Content-Type: application/json");
$input = json_decode(file_get_contents("php://input"), true);

$conn = new mysqli("localhost", "root", "", "agriculture_db");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO soil_data (userId, soilPh, moisture, nitrogen, phosphorus, potassium, soilType, fertilizerText, fertilizerProducts, cropRecommendations)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sdssssssss",
    $input["userId"],
    $input["soilPh"],
    $input["moisture"],
    $input["nitrogen"],
    $input["phosphorus"],
    $input["potassium"],
    $input["soilType"],
    $input["fertilizerText"],
    $input["fertilizerProducts"],
    $input["cropRecommendations"]
);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "recordId" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
