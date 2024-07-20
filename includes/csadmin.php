<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "YRPASS";
$database = "trueskill";

try {
 
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
   
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Function to retrieve master consulting entries
function getMasterConsulting($conn) {
    try {
        $stmt = $conn->query("SELECT master_consulting_name FROM masterconsultingtable");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array();
    }
}

// Function to add a master consulting entry
function addMasterConsulting($conn, $master_consulting_name) {
    try {
        // Check if the master consulting entry already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM masterconsultingtable WHERE master_consulting_name = :master_consulting_name");
        $stmt->bindParam(':master_consulting_name', $master_consulting_name);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            // Prepare SQL query to insert data
            $stmt = $conn->prepare("INSERT INTO masterconsultingtable (master_consulting_name) VALUES (:master_consulting_name)");
            
            // Bind parameters
            $stmt->bindParam(':master_consulting_name', $master_consulting_name);
            
            // Execute the query
            $stmt->execute();
            
            echo "Master Consulting added successfully.";
            
            // Redirect to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Master Consulting already exists.";
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

// Function to delete a master consulting entry
function deleteMasterConsulting($conn, $master_consulting_name) {
    try {
        // Prepare SQL query to delete data
        $stmt = $conn->prepare("DELETE FROM masterconsultingtable WHERE master_consulting_name = :master_consulting_name");
        
        // Bind parameters
        $stmt->bindParam(':master_consulting_name', $master_consulting_name);
        
        // Execute the query
        $stmt->execute();
        
        echo "Master Consulting deleted successfully.";
        
        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch(PDOException $e) {
        echo "Deletion failed: " . $e->getMessage();
    }
}

// Check if the form is submitted for adding a master consulting entry
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addMasterConsulting'])) {
    // Retrieve form data
    $master_consulting_name = $_POST['master_consulting_name'];
    
    // Add master consulting to the database
    addMasterConsulting($conn, $master_consulting_name);
}

// Check if the form is submitted for deleting a master consulting entry
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteMasterConsulting'])) {
    // Retrieve form data
    $master_consulting_name_to_delete = $_POST['master_consulting_name_to_delete'];
    
    // Delete master consulting from the database
    deleteMasterConsulting($conn, $master_consulting_name_to_delete);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Master Consulting</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        body {
            background: linear-gradient(135deg, #ff6a6a, #9150ff);
            color: #fff;
        }

        .container {
            margin-top: 50px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 5px;
        }

        .list-group-item {
            background-color: rgba(255, 255, 255, 0.7);
            margin-bottom: 5px;
            color: #333;
        }

        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1 align="center"> MASTER CONSULTING MODIFIER </h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Add Master Consulting</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="master_consulting_name">Master Consulting Name:</label>
                            <input type="text" id="master_consulting_name" name="master_consulting_name" class="form-control" required>
                        </div>
                        <button type="submit" name="addMasterConsulting" class="btn btn-primary">Add Master Consulting</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Delete Master Consulting</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="master_consulting_name_to_delete">Master Consulting Name:</label>
                            <input type="text" id="master_consulting_name_to_delete" name="master_consulting_name_to_delete" class="form-control" required>
                        </div>
                        <button type="submit" name="deleteMasterConsulting" class="btn btn-danger">Delete Master Consulting</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Existing Master Consulting</h2>
                <ul class="list-group">
                    <?php
                    // Display existing master consulting entries
                    $masterConsulting = getMasterConsulting($conn);
                    if ($masterConsulting) {
                        foreach ($masterConsulting as $consulting) {
                            echo "<li class='list-group-item'>{$consulting['master_consulting_name']}</li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>No master consulting entries found.</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h2>Modify Sub Consulting</h2>
                <form id="modifySubConsultingForm" method="post" action="">
                    <div class="form-group">
                        <label for="selected_master_consulting_name">Choose Master Consulting:</label>
                        <select id="selected_master_consulting_name" name="selected_master_consulting_name" class="form-control" required>
                            <option value="">Select Master Consulting</option>
                            <?php
                            // Populate dropdown with master consulting entries
                            foreach ($masterConsulting as $consulting) {
                                echo "<option value='{$consulting['master_consulting_name']}'>{$consulting['master_consulting_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById("selected_master_consulting_name").addEventListener("change", function() {
            // Get the selected master consulting entry
            var selectedConsulting = this.value;
            
            // Redirect to csadmin1.php with selected master consulting as query parameter
            window.location.href = "csadmin1.php?master_consulting_name=" + selectedConsulting;
        });
    </script>
    <script> document.body.style.color = "black"; </script>
</body>
</html>
