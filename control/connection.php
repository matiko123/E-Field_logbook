<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "fieldlogbook";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "<script>window.open('addvideo.html');</script>";
?>
