<?php
include '../db connect/connect.php';

$address        = $_POST['address'] ?? '';
$pole_condition = $_POST['pole_condition'] ?? '';
$notes          = $_POST['notes'] ?? '';
$hazards        = isset($_POST['hazards']) ? implode(", ", $_POST['hazards']) : '';
$severity       = $_POST['severity'] ?? '';
$photo_path     = null;

// Handle photo upload
if (!empty($_FILES['photo']['name'])) {
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $photo_path = $targetDir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $photo_path);
}

// Insert into DB
$sql = "INSERT INTO reports (address, pole_condition, notes, hazards, severity, photo_path) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $address, $pole_condition, $notes, $hazards, $severity, $photo_path);

if ($stmt->execute()) {
    echo "✅ Report submitted successfully!";
} else {
    echo "❌ Database error: " . $conn->error;
}
