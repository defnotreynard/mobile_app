<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelMS";

// DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'] ?? '';

if (empty($email)) {
  die("<script>alert('❌ Please enter your email.'); window.location.href='../forgot_password.html';</script>");
}

// 🔍 Check if email exists
$sql = "SELECT id FROM register WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
  die("<script>alert('❌ No account found with that email.'); window.location.href='../forgot_password.html';</script>");
}
$stmt->close();

// ✅ Simulate "email sent" popup
echo "<script>
  alert('📩 A password reset link has been sent to your email. Please check your inbox.');
  window.location.href = 'http://localhost/hotelMS/admin_page/login.html?email=" . urlencode($email) . "';
</script>";
exit();
