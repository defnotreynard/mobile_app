<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelMS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get POST values
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Check required fields
if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
  die("❌ All fields are required.");
}

// Check if passwords match
if ($password !== $confirm_password) {
  die("❌ Passwords do not match.");
}

// 🔍 Check if email already exists
$check_sql = "SELECT id FROM register WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
  die("❌ Email already registered. <a href='../register.html'>Try again</a>");
}
$check_stmt->close();

// Insert into DB
$sql = "INSERT INTO register (name, email, password, role) VALUES (?, ?, ?, 'admin')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
  // Redirect to login.html with success status
  header("Location: http://localhost/hotelMS/admin_page/login.html?status=registered");
  exit();
} else {
  echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
