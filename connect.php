<?php
// ✅ InfinityFree MySQL connection details
$servername = "localhost";   // Example: sql312.epizy.com (check in Control Panel)
$username   = "root";        // Your InfinityFree DB username
$password   = ""; // The password you created
$dbname     = "pole_trackerdb"; // Your DB name (the one you created)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("❌ Database connection failed: " . $conn->connect_error);
}
