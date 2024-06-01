<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "consulting";

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare SQL query to select master consulting courses
    $stmt = $conn->prepare("SELECT master_consulting_name FROM masterconsultingtable");
    
    // Execute the query
    $stmt->execute(); 
    
    // Fetch all rows
    $masterConsultingCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($masterConsultingCourses);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
