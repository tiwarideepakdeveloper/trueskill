<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "consulting";

if (isset($_GET['master_consulting_name'])) {
    $selected_master_consulting = $_GET['master_consulting_name'];

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare SQL query to select subconsulting courses
        $stmt = $conn->prepare("SELECT consulting_name FROM consultingtable WHERE master_consulting_name = :selected_master_consulting");
        $stmt->bindParam(':selected_master_consulting', $selected_master_consulting);
        
        // Execute the query
        $stmt->execute(); 
        
        // Fetch all rows
        $subconsultingCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($subconsultingCourses);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No master consulting course selected.']);
}
?>
