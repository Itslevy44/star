<?php
$servername = "localhost"; 
$username = "root";        
$password = "";          
$database = "star";        
$mysqli = new mysqli($servername, $username, $password, $database);
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
} 
