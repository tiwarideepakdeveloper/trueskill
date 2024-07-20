<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: includes/login.php');  
    exit();
}
?>
<?php include('includes/header.php'); ?>
<h4>Welcome to Admin Panel</h4>
<?php include('includes/footer.php'); ?>
