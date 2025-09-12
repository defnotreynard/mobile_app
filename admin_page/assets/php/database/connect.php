<?php
$servername = "localhost";   // Usually 'localhost'
$username   = "root";        // Default XAMPP/WAMP user
$password   = "";            // Default XAMPP/WAMP password is empty
$dbname     = "hotelms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
