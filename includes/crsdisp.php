<!-- Navbar -->
<div style="background-color: rgb(49, 194, 237); display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
        <img src="../assets/img/logos/trueskill.png" alt="Logo" style="height: 50px; margin-left:10vw;">
        <div style="display: flex; gap: 20px;">
            <span style="color: white; font-size: 20px; margin-right:2vw;">support@trueskill.in</span>
            <span style="color: white; font-size: 20px; margin-right:8vw;">+91 9381009246</span>
        </div>
    </div>

<!-- Driver Code -->
<?php
 
$servername = "localhost";
$username = "root";
$password = "YRPASS";
$database = "trueskill";

$parameter = $_GET['coursename'];

try {
     
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     
    $stmt = $conn->prepare("SELECT master_course_name, coursename, headerdata, img, questionsdata, skillunlock, bootcamp_message, content FROM coursetable WHERE coursename = :parameter");
    
    
    $stmt->bindParam(':parameter', $parameter);
    
    
    $stmt->execute();
     
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
         
        $master_course_name = $row["master_course_name"];
        $coursename = $row["coursename"];
        $headerdata = nl2br($row["headerdata"]); // Convert newline characters to <br> tags
        // Retrieve image data and convert it to base64 for display
        $img_data = base64_encode($row["img"]);
        $questionsdata = nl2br($row["questionsdata"]); // Convert newline characters to <br> tags
        $skillunlock = nl2br($row["skillunlock"]); // Convert newline characters to <br> tags
        $bootcamp_message = nl2br($row["bootcamp_message"]); // Convert newline characters to <br> tags
        $content = $row["content"];
    } else {
        $noDataFound = true;
    }
} catch(PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}

 
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="KreativDev" />
  <meta name="description" content="Multi-Tenant, Course, Course Selling" />
  <!-- Title -->
  <title>TrueSkill - Coaching | Consulting</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/images/logo/fav.png" type="image/x-icon" />
  <!-- Google font -->
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap"
    rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/vendors/bootstrap.min.css" />
  <!-- Fontawesome Icon CSS -->
  <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.min.css" />
  <!-- Icomoon Icon CSS -->
  <link rel="stylesheet" href="assets/fonts/icomoon/style.css" />
  <!-- Magnific Popup CSS -->
  <link rel="stylesheet" href="assets/css/vendors/magnific-popup.min.css" />
  <!-- NoUi Range Slider -->
  <link rel="stylesheet" href="assets/css/vendors/nouislider.min.css" />
  <!-- Swiper Slider -->
  <link rel="stylesheet" href="assets/css/vendors/swiper-bundle.min.css" />
  <!-- Nice Select -->
  <link rel="stylesheet" href="assets/css/vendors/nice-select.css" />
  <!-- AOS Animation CSS -->
  <link rel="stylesheet" href="assets/css/vendors/aos.min.css" />
  <!-- Animate CSS -->
  <link rel="stylesheet" href="assets/css/vendors/animate.min.css" />
  <!-- Main Style CSS -->
  <link rel="stylesheet" href="assets/css/style.css" />
  <!-- Responsive CSS -->
  <link rel="stylesheet" href="assets/css/responsive.css" />
  <!-- intenational phone number css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <style>
    ::placeholder {
      color: black;
    }

    input {
      color: black;
    }

    .list,
    li {
      line-height: 34px;

    }

    .footer-area {
      background-image: url("assets/images/banner/footer-2.jpg") !important;
      background-size: cover;
      background-repeat: no-repeat;
      opacity: 0.9;
    }

    .course-card {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background-color: white;
      border-radius: 5px;
      padding: 5%;
      align-items: center;
      border: 2px solid #30c2ec;
      position: relative;
      z-index: 2147483647 !important;
      height: 385px;
    }

    .course-card li {
      font-size: 14px;
      line-height: 1.3;
    }

    .course-card:before {
      content: "";
      position: absolute;
      left: -9px;
      top: 50%;
      translate: 0 -50%;
      width: 15px;
      height: 15px;
      background-color: white;
      transform: rotate(45deg);
      border: 2px solid #30c2ec;
      border-width: 0 0 2px 2px;
    }

    .left .course-card:before {
      left: unset;
      right: -9px;
      transform: rotate(-135deg);
      
    }
  </style>
</head>

<body>
    <div class='container'>
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php elseif (isset($noDataFound) && $noDataFound) : ?>
            <p>No data found in the database.</p>
        <?php else : ?>
          
          <!-- Display Area Starts -->
          <div style="font-size:2vw;">

          <div class='header' style="text-align: center; font-size:8vw;">  
            <?php echo str_replace('<br>', "\n", $coursename) ; ?>
          </div>

          <br>

          <p class="text-center" style="text-align: center;">
                <span style="
                      background-color: #f44b4b;
                      padding: 10px;
                      line-height: 3;
                    "><b>
                    Save 50% of your time by learning this course from Working
                    Professionals / Industry Experts</b></span>
          </p>
             
          <br>

          <div class='course-info' style="color:brown; text-align: center; font-size:5vw;">
              <?php echo str_replace("\n",'<br>' ,  $headerdata); ?>
          </div>

          <br>

          <div class='course-info' style="text-align: center;">
              <img src='data:image/jpeg;base64,<?php echo $img_data; ?>' alt='Course Image' style="width: 70%; height:70%; display: block; margin: 0 auto;">
          </div>

          <br>

          <div class="content-title mb-30" style="text-align: center;">
              <h4 class="title">Answer Below Questions !</h4>
          </div>

          <br>


            <div class='course-info' style="text-align: center;">
                <?php echo str_replace("\n",'<br>' , $questionsdata); ?> 
            </div>

            <br>

            <p class="text-center" style="text-align:center;">
                <span style="
                      background-color: #f44b4b;
                      padding: 10px;
                      line-height: 3;
                    "><b style="text-align: center;">
                    Unlock your TrueSkill to become A Certified Advanced  
                Expert now !!</b></span> <br> <h5 style="text-align: center;">(Hurry, seats are filling up fast!)</h5>
            </p>

            <br>

            <div class='course-info' style="text-align: center;">
                
                <?php echo str_replace("\n",'<br>', $skillunlock);  ?> 
            </div>

            <br>

            <div class='course-info' style="text-align: center;">
                 
               <?php echo str_replace("\n",'<br>' , $bootcamp_message); ?> 
            </div>

            <br>
               
              <div class="content-title mb-30" style="text-align: center;">
                  <h4 class="title">What will you learn - Course Content</h4>
              </div>

            <br>

            <div class='course-info' style="text-align: center;">
                 
                 <?php echo str_replace( "\n" ,'<br>' , $content); ?> 
            </div>
 
            <br>

            <p class="text-center" style="text-align:center;">
                <span style="
                      background-color: #f44b4b;
                      padding: 10px;
                      line-height: 3;
                    "><b style="text-align: center;">
                    Unlock your TrueSkill to become A Certified Advanced  
                Expert now !!</b></span> <br> <h5 style="text-align: center;">(Hurry, seats are filling up fast!)</h5>
            </p>

            <br>
            </div>
      

        <?php endif; ?> 
    </div>
</body>
</html>

<div class="col-lg-5" data-aos="fade-up">
  <div class="faq-form border radius-md p-30 mb-40" style="border: 1px solid #ddd; border-radius: 8px; padding: 30px; margin-bottom: 40px;">
    <div class="content mb-20">
      <h3 class="title mb-0" style="font-size: 24px; font-weight: bold;">Have Any Question?</h3>
    </div>
    <form id="contactForm" action="https://formsubmit.co/support@trueskill.in" method="POST">
       
      <div class="row">
        <div class="col-md-6">
          <div class="form-group mb-20" style="margin-bottom: 20px;">
            <input type="text" name="name" class="form-control" id="name" required
              placeholder="Your name*" style="color:black; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" />
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group mb-20" style="margin-bottom: 20px;">
            <input type="email" name="email" class="form-control" id="email" required
              pattern="[a-zA-Z0-9]+[@][a-z]+[.][a-z]{2,}" title="Please enter a valid email address"
              placeholder="Your email*" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" />
          </div>
        </div>

        <div class="col-12">
          <div class="form-group mb-20" style="margin-bottom: 20px;">
            <input type="text" name="subject" class="form-control" id="subject" required
              placeholder="Your subject" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" />
          </div>
        </div>

        <div class="col-12">
          <div class="form-group mb-20" style="margin-bottom: 20px;">
            <textarea name="message" id="message" class="form-control" cols="30" rows="8"
              placeholder="Your Message..." minlength="100" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
          </div>
        </div>

        <div class="col-md-12 text-center">
          <button type="submit" class="btn btn-lg btn-primary rounded-pill" title="Send message"
            style="background-color: #f44b4b; color: #fff; padding: 10px 30px; border: none; border-radius: 50px; font-size: 16px;">
            Send Your Message
          </button>
        </div>
      </div>
    </form>
  </div>
</div>


 


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
