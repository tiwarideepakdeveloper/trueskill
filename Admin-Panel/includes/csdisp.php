<!-- Navbar -->
<div style="background-color: rgb(49, 194, 237); display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
        <img src="../assets/img/logos/trueskill.png" alt="Logo" style="height: 50px; margin-left:10vw;">
        <div style="display: flex; gap: 20px;">
            <span style="color: white; font-size: 20px; margin-right:2vw;">support@trueskill.in</span>
            <span style="color: white; font-size: 20px; margin-right:8vw;">+91 9381009246</span>
        </div>
</div>

<!--Driver Code -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "consulting";

$parameter = $_GET['consulting_name'];

try {
    
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     
    $stmt = $conn->prepare("SELECT carddata, consulting_name, headerdata, master_consulting_name FROM consultingtable WHERE consulting_name = :parameter");
    
  
    $stmt->bindParam(':parameter', $parameter);
    
     
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
         
        $master_consulting_name = $row["master_consulting_name"];
        $consulting_name = $row["consulting_name"];
        $headerdata = nl2br($row["headerdata"]); // Convert newline characters to <br> tags
        $carddata = nl2br($row["carddata"]); // Convert newline characters to <br> tags
    } else {
        $noDataFound = true;
    }
} catch(PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Consulting Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .consulting-info {
            margin-bottom: 10px;
        }
        .consulting-info label {
            display: block;
            font-weight: bold;
        }
        .consulting-info input[type='text'],
        .consulting-info textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
     <br>
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php elseif (isset($noDataFound) && $noDataFound) : ?>
            <p>No data found in the database.</p>
        <?php else : ?>

            <div style="font-size:2vw;">

            <div class='consulting-info' style="text-align: center; font-size:6vw; color:brown" >
                 
                 <?php  echo str_replace('<br>', "\n", $consulting_name); ?> 
            </div>

            <br>

            <div class='consulting-info' style="text-align: center;">
                 
                 <?php  echo str_replace("\n",'<br>' , $headerdata); ?> 
            </div>
            
            <br>
            
            <div class='consulting-info' style="text-align: center;">
               
                 <?php echo str_replace( "\n",'<br>', $carddata); ?> 
            </div>

        <?php endif; ?>
    <br>
        </div> 
</body>
</html>

<form id="contactForm" action="https://formsubmit.co/consultingservices@trueskill.in" method="POST" autocomplete="off" style="padding: 20px; border: 1px solid #eaeaea; border-radius: 10px; background-color: #f9f9f9;">
  <input type="hidden" name="_captcha" value="false">
  <div class="form-group mb-20" style="margin-bottom: 20px;">
    <input type="text" name="name" class="form-control form-control-sm" id="name" required="" placeholder="Full Name *" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>
  <div class="form-group mb-20" style="margin-bottom: 20px;">
    <input type="tel" name="phone" class="form-control form-control-sm" id="phone" required="" placeholder="Phone Number *" pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>
  <div class="form-group mb-20" style="margin-bottom: 20px;">
    <input type="email" name="email" class="form-control" id="email" required="" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address" placeholder="Business email *" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>
  <div class="form-group mb-20" style="margin-bottom: 20px;">
    <input type="text" name="requirements" class="form-control form-control-sm" id="requirements" required="" placeholder="Requirements *" minlength="50" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>
  <div class="form-group mb-20" style="margin-bottom: 20px; text-align: center;">
    <button class="btn btn-lg btn-danger rounded-pill" type="submit" aria-label="apply now" style="background-color: #f44b4b; padding: 10px 20px; border: none; border-radius: 25px; color: white; font-size: 16px; cursor: pointer;">
      Send Now
    </button>
  </div>
</form>

<!--Footer -->
 
    <div style="display: flex; justify-content: space-between; background-color: rgb(32,74,113); color: whitesmoke; padding: 20px;">
        <!-- Left Side -->
        <div style="max-width: 400px;">
            <img src="../assets/img/logos/trueskill.png" alt="Logo" style="height: 50px; margin-left: 10vw;">
            <p style="margin-top: 10px;">
                True Skill is a Professional Online Coaching and Consulting Platform led by a group of Passionate and Committed Working Professionals & Industry Experts from diverse domains. Sit back and relax, let us handle your responsibilities with expertise and care so you can focus on taking your job performance to the next level (or) growing your business!
            </p>
        </div>
        
        <!-- Right Side -->
        <div class="footer-widget" style="max-width: 200px; margin-left: auto;" data-aos="fade-up" data-aos-delay="200">
            <h5 style="color: whitesmoke;">Useful Links</h5>
            <ul class="footer-links text-right" style="list-style-type: none; padding: 0; margin: 0;">
                <li style="display: flex; flex-direction: row; align-items: center; transition: font-size 0.1s; margin-left: auto;" onmouseover="this.style.fontSize='105%'" onmouseout="this.style.fontSize='100%'">
                    <i class="fas fa-arrow-right"></i>
                    <a href="contact-us.html" target="_self" title="link" style="margin-left: 3%; color: whitesmoke; text-decoration: none;">Contact Us</a>
                </li>
                <li style="display: flex; flex-direction: row; align-items: center; transition: font-size 0.1s;" onmouseover="this.style.fontSize='105%'" onmouseout="this.style.fontSize='100%'">
                    <i class="fas fa-arrow-right"></i>
                    <a href="refund-policy.html" target="_self" title="link" style="margin-left: 3%; color: whitesmoke; text-decoration: none;">Refund Policy</a>
                </li>
                <li style="display: flex; flex-direction: row; align-items: center; transition: font-size 0.1s;" onmouseover="this.style.fontSize='103%'" onmouseout="this.style.fontSize='100%'">
                    <i class="fas fa-arrow-right"></i>
                    <a href="term-of-service.html" target="_self" title="link" style="margin-left: 3%; color: whitesmoke; text-decoration: none;">Terms of Services</a>
                </li>
                <li style="display: flex; flex-direction: row; align-items: center; transition: font-size 0.1s;" onmouseover="this.style.fontSize='105%'" onmouseout="this.style.fontSize='100%'">
                    <i class="fas fa-arrow-right"></i>
                    <a href="privacy-policy.html" target="_self" title="link" style="margin-left: 3%; color: whitesmoke; text-decoration: none;">Privacy Policy</a>
                </li>
                <li style="display: flex; flex-direction: row; align-items: center;" onmouseover="this.style.fontSize='105%'" onmouseout="this.style.fontSize='100%'">
                    <i class="fas fa-arrow-right"></i>
                    <a href="about-us.html" target="_self" title="link" style="margin-left: 3%; color: whitesmoke; text-decoration: none; transition: font-size 0.3s;">About Us</a>
                </li>
            </ul>
        </div>
    </div>
