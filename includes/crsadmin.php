<?php
 
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

 
function getMasterCourses($conn) {
    try {
        $stmt = $conn->query("SELECT master_course_name FROM mastercoursetable");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array();
    }
}

// Function to add a master course
function addMasterCourse($conn, $master_course_name) {
    try {
        // Check if the master course already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM mastercoursetable WHERE master_course_name = :master_course_name");
        $stmt->bindParam(':master_course_name', $master_course_name);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            // Prepare SQL query to insert data
            $stmt = $conn->prepare("INSERT INTO mastercoursetable (master_course_name) VALUES (:master_course_name)");
            
            // Bind parameters
            $stmt->bindParam(':master_course_name', $master_course_name);
            
            // Execute the query
            $stmt->execute();
            
            echo "Master Course added successfully.";
            
            // Redirect to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Master Course already exists.";
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}


// Function to delete a master course
function deleteMasterCourse($conn, $master_course_name) {
    try {
        // Prepare SQL query to delete data
        $stmt = $conn->prepare("DELETE FROM mastercoursetable WHERE master_course_name = :master_course_name");
        
        // Bind parameters
        $stmt->bindParam(':master_course_name', $master_course_name);
        
        // Execute the query
        $stmt->execute();
        
        echo "Master Course deleted successfully.";
        
        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch(PDOException $e) {
        echo "Deletion failed: " . $e->getMessage();
    }
}

// Check if the form is submitted for adding a master course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addMasterCourse'])) {
    // Retrieve form data
    $master_course_name = $_POST['master_course_name'];
    
    // Add master course to the database
    addMasterCourse($conn, $master_course_name);
}

// Check if the form is submitted for deleting a master course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteMasterCourse'])) {
    // Retrieve form data
    $master_course_name_to_delete = $_POST['master_course_name_to_delete'];
    
    // Delete master course from the database
    deleteMasterCourse($conn, $master_course_name_to_delete);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Master Courses</title>
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
    <h1 align="center"> MASTER COURSE MODIFIER </h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Add Master Course</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="master_course_name">Master Course Name:</label>
                            <input type="text" id="master_course_name" name="master_course_name" class="form-control" required>
                        </div>
                        <button type="submit" name="addMasterCourse" class="btn btn-primary">Add Master Course</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <h2>Delete Master Course</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="master_course_name_to_delete">Master Course Name:</label>
                            <input type="text" id="master_course_name_to_delete" name="master_course_name_to_delete" class="form-control" required>
                        </div>
                        <button type="submit" name="deleteMasterCourse" class="btn btn-danger">Delete Master Course</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Existing Master Courses</h2>
                <ul class="list-group">
                    <?php
                    // Display existing master courses
                    $masterCourses = getMasterCourses($conn);
                    if ($masterCourses) {
                        foreach ($masterCourses as $masterCourse) {
                            echo "<li class='list-group-item'>{$masterCourse['master_course_name']}</li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>No master courses found.</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h2>Modify Sub Course</h2>
                <form id="modifySubCourseForm" method="post" action="">
                    <div class="form-group">
                        <label for="selected_master_course_name">Choose Master Course:</label>
                        <select id="selected_master_course_name" name="selected_master_course_name" class="form-control" required>
                            <option value="">Select Master Course</option>
                            <?php
                            // Populate dropdown with master courses
                            foreach ($masterCourses as $masterCourse) {
                                echo "<option value='{$masterCourse['master_course_name']}'>{$masterCourse['master_course_name']}</option>";
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
        document.getElementById("selected_master_course_name").addEventListener("change", function() {
            // Get the selected master course
            var selectedCourse = this.value;
            
            // Redirect to crsadmin1.php with selected master course as query parameter
            window.location.href = "crsadmin1.php?master_course=" + selectedCourse;
        });
    </script>
    <script> document.body.style.color = "black"; </script>
</body>
</html>
