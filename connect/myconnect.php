<?php
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "thietkeweb";

// Create connection
$conn = new mysqli($servername, $username, $password,$databasename);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else{
    mysqli_set_charset($conn, 'utf8');
}

?>