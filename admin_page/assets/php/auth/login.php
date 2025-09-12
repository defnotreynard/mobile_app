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

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
  die("❌ Email and Password are required.");
}

// 🔍 Check if email + password match
$sql = "SELECT id, name, role FROM register WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // ✅ Login success → go to dashboard
  header("Location: http://localhost/hotelMS/admin_page/index.html");
  exit();
} else {
  // ❌ Login failed → go back to login with error
  header("Location: http://localhost/hotelMS/admin_page/login.html?status=invalid");
  exit();
}

$stmt->close();
$conn->close();
