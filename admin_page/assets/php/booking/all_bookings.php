<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT booking_id, booking_code, name, room_type, total_members, booking_date, booking_time, 
        arrival_date, departure_date, email, phone, file_path, message 
        FROM add_bookings ORDER BY booking_id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['booking_id'] . "</td>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['room_type']) . "</td>";
    echo "<td>" . $row['total_members'] . "</td>";
    echo "<td>" . $row['booking_date'] . "</td>";
    echo "<td>" . $row['booking_time'] . "</td>";
    echo "<td>" . $row['arrival_date'] . "</td>";
    echo "<td>" . $row['departure_date'] . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
    echo "<td>Pending</td>";
    echo "<td class='text-right'>";
    echo "

    <a href='http://localhost/hotelMS/admin_page/edit-booking.html?code=" . urlencode($row['booking_code']) . "' class='btn btn-sm btn-primary'>Edit</a>
    <a href='assets/php/booking/delete_bookings.php?code=" . urlencode($row['booking_code']) . "' class='btn btn-sm btn-danger'>Delete</a>
    ";
    echo "</td>";

    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='12' class='text-center'>No bookings found</td></tr>";
}

$conn->close();
