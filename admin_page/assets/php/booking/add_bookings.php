<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// 🔹 Find the first missing booking_id (gapless)
$result = $conn->query("
    SELECT MIN(t1.booking_id + 1) AS next_id
    FROM add_bookings t1
    LEFT JOIN add_bookings t2 ON t1.booking_id + 1 = t2.booking_id
    WHERE t2.booking_id IS NULL
");

$row = $result->fetch_assoc();
$next_id = $row['next_id'] ?? 1; // Start from 1 if table empty
if ($next_id < 1) {
  $next_id = 1; // Ensure we start from 1
}

// 🔹 Generate random booking code
$random_number = rand(1000, 9999);
$booking_code = "BKG-" . $random_number;


// ✅ Get POST values safely
$name = isset($_POST['name']) ? trim($_POST['name']) : null;
$room_type = isset($_POST['room_type']) ? trim($_POST['room_type']) : null;
$total_members = isset($_POST['total_members']) ? trim($_POST['total_members']) : null;
$booking_date = isset($_POST['booking_date']) ? trim($_POST['booking_date']) : null;
$booking_time = isset($_POST['booking_time']) ? trim($_POST['booking_time']) : null;
$arrival_date = isset($_POST['arrival_date']) ? trim($_POST['arrival_date']) : null;
$departure_date = isset($_POST['departure_date']) ? trim($_POST['departure_date']) : null;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
$message = isset($_POST['message']) ? trim($_POST['message']) : null;

// ✅ Stop if required field is missing
if (empty($name) || empty($room_type) || empty($total_members) || empty($booking_date) || empty($departure_date)) {
  die("❌ Error: Please fill in all required fields.");
}

// 🔹 File upload
$file_path = "";
if (isset($_FILES['filename']) && $_FILES['filename']['error'] == 0) {
  $target_dir = "uploads/";
  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
  }
  $file_path = $target_dir . basename($_FILES["filename"]["name"]);
  move_uploaded_file($_FILES["filename"]["tmp_name"], $file_path);
}

// 🔹 Insert query (include booking_id now)
$sql = "INSERT INTO add_bookings 
        (booking_id, booking_code, name, room_type, total_members, booking_date, booking_time, arrival_date, departure_date, email, phone, file_path, message)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
  "isssissssssss",
  $next_id,
  $booking_code,
  $name,
  $room_type,
  $total_members,
  $booking_date,
  $booking_time,
  $arrival_date,
  $departure_date,
  $email,
  $phone,
  $file_path,
  $message
);

if ($stmt->execute()) {
  // Redirect back to form with success message
  header("Location: http://localhost/hotelMS/admin_page/add-booking.html?status=success&code=" . urlencode($booking_code));
  exit;
} else {
  // Redirect with error
  header("Location: http://localhost/hotelMS/admin_page/add-booking.html?status=error&msg=" . urlencode($stmt->error));
  exit;
}
