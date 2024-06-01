<?php
session_start();  

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "login/register";  

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['loginBtn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Retrieve user from database
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['password']) {  
                // Set session variables
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                var_dump($_SESSION['username']);
                // Redirect to the index page
                header('Location: ../index.php'); 
                exit();
            } else {
                $loginMessage = "Invalid password!";
            }
        } else {
            $loginMessage = "User not found!";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .code-container {
            border-radius: 0.3em;
            padding: 20px;
            margin: 20px;
        }
        .navbar {
            background-color: #67004E;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar ul {
            list-style-type: none;
            margin-left: 7vw;
            margin-right:7vw;
            padding: 0;
            display: flex;
            gap: 50px;
        }
        .navbar li {
            display: inline;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .buttons {
            display: flex;
            margin-bottom: 20px;
        }
        button {
            margin: 5px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            outline: none;
            background: #0257a4;  
            border-radius: 5px;
            color: #fff;
            opacity:0.5;
        }
        button.active {
            opacity: 1;
        }
        form {
            display: none;
            width: 300px;
            margin-bottom: 20px;
        }
        form.active {
            display: block;
        }
        label {
            display: block;
            margin-bottom: 1.95vw;
            margin-top: 1.95vw;
        }
        input[type="text"],
        input[type="password"],
        input[type="checkbox"] {
            width: 80%;
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            width: 80%;
            padding: 10px;
            background-color: #0257a4;  
            margin: 5px;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #004f90;  
        }
    
    </style>
</head>
<body>
    <div class="code-container">

        <div class="container" style="border-style:solid; margin-left:30vw; margin-right:30vw; border-radius:2vw;"> 
            
            <!-- Login Form -->
            <form id="loginForm" class="active" method="post" action="login.php">
                <label for="login-username">Username* or Email*</label>
                <input type="text" id="login-username" name="username" required>
                <label for="login-password">Password*</label>
                <input type="password" id="login-password" name="password"  required> <br><br><br>
                <input type="submit" name="loginBtn" value="Login" style="margin-left:20px">
            </form>
            
            <?php if(isset($loginMessage)) { echo "<p>$loginMessage</p>"; } ?>
        </div>
    </div>

    <script>
        function toggleForm(formType) {
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');

            if (formType === 'login') {
                loginForm.classList.add('active');
                loginBtn.classList.add('active');
            }
        }
    </script>
</body>
</html>
