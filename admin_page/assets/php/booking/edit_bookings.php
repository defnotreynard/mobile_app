<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// 🔹 Fetch booking details (GET by booking_code)
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['code'])) {
  $booking_code = $_GET['code'];
  $sql = "SELECT booking_id, booking_code, name, room_type, total_members, booking_date, booking_time, arrival_date, departure_date, email, phone, file_path, message 
          FROM add_bookings WHERE booking_code = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $booking_code);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();

  echo json_encode($data);
  exit;
}

// 🔹 Update booking details (POST by booking_code)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $booking_code = $_POST['booking_code']; // use booking_code instead of booking_id
  $name = $_POST['name'];
  $room_type = $_POST['room_type'];
  $total_members = $_POST['total_members'];
  $booking_date = $_POST['booking_date'];
  $booking_time = $_POST['booking_time'];
  $arrival_date = $_POST['arrival_date'];
  $departure_date = $_POST['departure_date'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $message = $_POST['message'];

  // Handle file upload if new file is chosen
  $file_path = null;
  if (!empty($_FILES['file_path']['name'])) {
    $target_dir = "uploads/";
    $file_path = $target_dir . basename($_FILES["file_path"]["name"]);
    move_uploaded_file($_FILES["file_path"]["tmp_name"], $file_path);
  }

  $sql = "UPDATE add_bookings 
          SET name=?, room_type=?, total_members=?, booking_date=?, booking_time=?, arrival_date=?, departure_date=?, email=?, phone=?, message=?"
    . ($file_path ? ", file_path=?" : "") .
    " WHERE booking_code=?";

  if ($file_path) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
      "ssisssssssss",
      $name,
      $room_type,
      $total_members,
      $booking_date,
      $booking_time,
      $arrival_date,
      $departure_date,
      $email,
      $phone,
      $message,
      $file_path,
      $booking_code
    );
  } else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
      "ssissssssss",
      $name,
      $room_type,
      $total_members,
      $booking_date,
      $booking_time,
      $arrival_date,
      $departure_date,
      $email,
      $phone,
      $message,
      $booking_code
    );
  }

  if ($stmt->execute()) {
    // redirect back to list
    header("Location: http://localhost/hotelMS/admin_page/all-booking.html?updated=1");
    exit;
  } else {
    echo "Error updating booking: " . $conn->error;
  }
}

$conn->close();
