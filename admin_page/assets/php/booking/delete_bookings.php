<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if booking_code is passed
if (isset($_GET['code'])) {
  $booking_code = $_GET['code'];

  // Use prepared statement to avoid SQL injection
  $stmt = $conn->prepare("DELETE FROM add_bookings WHERE booking_code = ?");
  $stmt->bind_param("s", $booking_code);

  if ($stmt->execute()) {
    // Redirect back to all bookings after deletion
    header("Location: http://localhost/hotelMS/admin_page/all-booking.html");
    exit();
  } else {
    echo "Error deleting record: " . $conn->error;
  }

  $stmt->close();
} else {
  echo "Invalid request!";
}

$conn->close();
