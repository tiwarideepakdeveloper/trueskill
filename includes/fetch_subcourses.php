<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "YRPASS";
$database = "trueskill";

if (isset($_GET['master_course'])) {
    $selected_master_course = $_GET['master_course'];

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare SQL query to select subcourses
        $stmt = $conn->prepare("SELECT coursename FROM coursetable WHERE master_course_name = :selected_master_course");
        $stmt->bindParam(':selected_master_course', $selected_master_course);
        
        // Execute the query
        $stmt->execute(); 
        
        // Fetch all rows
        $subcourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($subcourses);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No master course selected.']);
}
?>
