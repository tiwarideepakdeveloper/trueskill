<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "YRPASS";
$database = "trueskill";

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Retrieve master courses
    $stmt = $conn->query("SELECT master_course_name FROM mastercoursetable");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($courses);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
