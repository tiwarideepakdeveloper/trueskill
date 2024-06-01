<?php
 
$servername = "localhost";
$username = "root";
$password = "";
$database = "course";

 
function deleteCourse($conn, $coursename) {
    try {
         
        $stmt = $conn->prepare("SELECT COUNT(*) FROM coursetable WHERE coursename = :coursename");
        $stmt->bindParam(':coursename', $coursename);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
             
            $stmt = $conn->prepare("DELETE FROM coursetable WHERE coursename = :coursename");
            
         
            $stmt->bindParam(':coursename', $coursename);
            
             
            $stmt->execute();
            
            echo "Course deleted successfully.";
        } else {
            echo "Course does not exist.";
        }
    } catch(PDOException $e) {
        echo "Deletion failed: " . $e->getMessage();
    }
}

// Check if the form is submitted for adding a course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addCourse'])) {
    // Retrieve form data
    $coursename = $_POST['coursename'];
    $headerdata = $_POST['headerdata'];
    // Get image data
    $img = file_get_contents($_FILES['img']['tmp_name']);
    $questionsdata = $_POST['questionsdata'];
    $skillunlock = $_POST['skillunlock'];
    $bootcamp_message = $_POST['bootcamp_message'];
    $master_course_name = $_POST['master_course_name']; 
    $content = $_POST['content']; 
    
    try {
    
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        
     
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    
        $stmt = $conn->prepare("INSERT INTO coursetable (coursename, headerdata, img, questionsdata, skillunlock, bootcamp_message, master_course_name, content) VALUES (:coursename, :headerdata, :img, :questionsdata, :skillunlock, :bootcamp_message, :master_course_name, :content)");

        $stmt->bindParam(':coursename', $coursename);
        $stmt->bindParam(':headerdata', $headerdata);
        $stmt->bindParam(':img', $img, PDO::PARAM_LOB); // Use PDO::PARAM_LOB to indicate a BLOB parameter
        $stmt->bindParam(':questionsdata', $questionsdata);
        $stmt->bindParam(':skillunlock', $skillunlock);
        $stmt->bindParam(':bootcamp_message', $bootcamp_message);
        $stmt->bindParam(':master_course_name', $master_course_name); // New field
        $stmt->bindParam(':content', $content); // New field

        $stmt->execute();

        
        echo "Course added successfully.";
        header("Location: ./crsdisp.php?coursename=$coursename");
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteCourse'])) {

    $coursenameToDelete = $_POST['coursenameToDelete'];
    
    try {

        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        
      
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
        deleteCourse($conn, $coursenameToDelete);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
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
    <h1 align="center"> SUB COURSE MODIFIER </h1>
    <div class="container">
        <h2>Add Sub Course</h2>
        <div class="form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="coursename">Course Name:</label>
                    <input type="text" id="coursename" name="coursename" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="headerdata">Header Data:</label>
                    <input type="text" id="headerdata" name="headerdata" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="img">Image:</label>
                    <input type="file" id="img" name="img" class="form-control-file" required>
                </div>
                <div class="form-group">
                    <label for="questionsdata">Questions Data:</label>
                    <input type="text" id="questionsdata" name="questionsdata" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="skillunlock">Skill Unlock:</label>
                    <input type="text" id="skillunlock" name="skillunlock" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="bootcamp_message">Bootcamp Message:</label>
                    <input type="text" id="bootcamp_message" name="bootcamp_message" class="form-control" required>
                </div>
                <div class="form-group"> <!-- New field -->
                    <label for="master_course_name">Master Course Name:</label>
                    <input type="text" id="master_course_name" name="master_course_name" class="form-control" required>
                </div>
                <div class="form-group"> <!-- New field -->
                    <label for="content">Content:</label>
                    <input type="text" id="content" name="content" class="form-control" required>
                </div>
                <input type="submit" name="addCourse" value="Add Course" class="btn btn-primary">
            </form>
        </div>

        <h2>Delete Sub Course</h2>
        <div class="form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="coursenameToDelete">Course Name:</label>
                    <input type="text" id="coursenameToDelete" name="coursenameToDelete" class="form-control" required>
                </div>
                <input type="submit" name="deleteCourse" value="Delete Course" class="btn btn-danger">
            </form>
        </div>

        <h2>Existing Sub Courses</h2>
        <div class="list-group">
            <?php
            // Retrieve existing courses from the database where master course name matches the parameter
            if(isset($_GET['master_course'])) {
                $selected_master_course = $_GET['master_course'];
                try {
                    // Connect to MySQL using PDO
                    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                    
                    // Set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Prepare SQL query to select data
                    $stmt = $conn->prepare("SELECT coursename FROM coursetable WHERE master_course_name = :selected_master_course");
                    $stmt->bindParam(':selected_master_course', $selected_master_course);
                    
                    // Execute the query
                    $stmt->execute();
                    
                    // Fetch all rows
                    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // Output the list of courses
                    if ($courses) {
                        foreach ($courses as $course) {
                            echo "<div class='list-group-item'>{$course['coursename']} <form method='post' style='display:inline'><input type='hidden' name='coursenameToDelete' value='{$course['coursename']}'><input type='submit' name='deleteCourse' value='Delete' class='btn btn-sm btn-danger'></form></div>";
                        }
                    } else {
                        echo "<div class='list-group-item'>No courses found in the database for the selected master course.</div>";
                    }
                } catch(PDOException $e) {
                    echo "<div class='list-group-item'>Connection failed: " . $e->getMessage() . "</div>";
                }
            } else {
                echo "<div class='list-group-item'>No master course selected.</div>";
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
