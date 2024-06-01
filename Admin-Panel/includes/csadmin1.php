<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "consulting";

// Function to delete a consulting record
function deleteConsulting($conn, $consulting_name) {
    try {
        // Check if the consulting record exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM consultingtable WHERE consulting_name = :consulting_name");
        $stmt->bindParam(':consulting_name', $consulting_name);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            // Prepare SQL query to delete data
            $stmt = $conn->prepare("DELETE FROM consultingtable WHERE consulting_name = :consulting_name");
            
            // Bind parameters
            $stmt->bindParam(':consulting_name', $consulting_name);
            
            // Execute the query
            $stmt->execute();
            
            echo "Consulting record deleted successfully.";
        } else {
            echo "Consulting record does not exist.";
        }
    } catch(PDOException $e) {
        echo "Deletion failed: " . $e->getMessage();
    }
}

 
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Check if the form is submitted for adding a consulting record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addConsulting'])) {
    // Retrieve form data
    $master_consulting_name = $_POST['master_consulting_name'];
    $consulting_name = $_POST['consulting_name'];
    $headerdata = $_POST['headerdata'];
    $carddata = $_POST['carddata'];
    
    try {
        // Prepare SQL query to insert data
        $stmt = $conn->prepare("INSERT INTO consultingtable (master_consulting_name, consulting_name, headerdata, carddata) VALUES (:master_consulting_name, :consulting_name, :headerdata, :carddata)");

        // Bind parameters
        $stmt->bindParam(':master_consulting_name', $master_consulting_name);
        $stmt->bindParam(':consulting_name', $consulting_name);
        $stmt->bindParam(':headerdata', $headerdata);
        $stmt->bindParam(':carddata', $carddata);

        // Execute the query
        $stmt->execute();

        echo "Consulting record added successfully.";
        header("Location: ./csdisp.php?consulting_name=$consulting_name");
        exit();
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

// Check if the form is submitted for deleting a consulting record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteConsulting'])) {
    // Retrieve form data
    $consulting_nameToDelete = $_POST['consulting_nameToDelete'];
    
    // Call deleteConsulting function to delete the consulting record
    deleteConsulting($conn, $consulting_nameToDelete);
}

// Retrieve existing consulting records from the database where master consulting name matches the parameter
$consultingRecords = [];
if(isset($_GET['master_consulting_name'])) {
    $selected_master_consulting_name = $_GET['master_consulting_name'];
    try {
        // Prepare SQL query to select data
        $stmt = $conn->prepare("SELECT consulting_name FROM consultingtable WHERE master_consulting_name = :selected_master_consulting_name");
        $stmt->bindParam(':selected_master_consulting_name', $selected_master_consulting_name);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch all rows
        $consultingRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Consulting Records</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #FF69B4, #800080);
            color: white;
        }

        .container {
            margin-top: 50px;
        }

        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }

        .list-group-item {
            background-color: #f3f3f3;
            margin-bottom: 5px;
        }

        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1 align="center"> CONSULTING RECORD MODIFIER </h1>
    <div class="container">
        <h2>Add Consulting Record</h2>
        <div class="form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="master_consulting_name">Master Consulting Name:</label>
                    <input type="text" id="master_consulting_name" name="master_consulting_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="consulting_name">Consulting Name:</label>
                    <input type="text" id="consulting_name" name="consulting_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="headerdata">Header Data:</label>
                    <input type="text" id="headerdata" name="headerdata" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="carddata">Card Data:</label>
                    <input type="text" id="carddata" name="carddata" class="form-control" required>
                </div>
                <input type="submit" name="addConsulting" value="Add Consulting Record" class="btn btn-primary">
            </form>
        </div>

        <h2>Delete Consulting Record</h2>
        <div class="form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="consulting_nameToDelete">Consulting Name:</label>
                    <input type="text" id="consulting_nameToDelete" name="consulting_nameToDelete" class="form-control" required>
                </div>
                <input type="submit" name="deleteConsulting" value="Delete Consulting Record" class="btn btn-danger">
            </form>
        </div>

        <h2>Existing Consulting Records</h2>
        <div class="list-group">
            <?php
            // Output the list of consulting records
            if ($consultingRecords) {
                foreach ($consultingRecords as $record) {
                    echo "<div class='list-group-item'>{$record['consulting_name']} <form method='post' style='display:inline'><input type='hidden' name='consulting_nameToDelete' value='{$record['consulting_name']}'><input type='submit' name='deleteConsulting' value='Delete' class='btn btn-sm btn-danger'></form></div>";
                }
            } else {
                echo "<div class='list-group-item'>No consulting records found in the database for the selected master consulting name.</div>";
            }
            ?>
        </div>
    </div>

    <script> document.body.style.color="black";</script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
