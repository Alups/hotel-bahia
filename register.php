<?php
include 'includes/db.php';


if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };

if(isset($_POST['submit'])){

    if(isset($_POST['email'])){
       $email = $_POST['email'];
       if($email == ''){
           unset($email);
       }
   }
 
   if(isset($_POST['pass'])){
       $password = $_POST['pass'];
       if($password == ''){
           unset($password);
       }
   }
 
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $l_name = $_POST['l_name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    // $address = $_POST['address'];
    // $address = filter_var($address, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
 
 
    if(!empty($email) && !empty($password)){
 
       function getToken($len=32){
           return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
       }
 
       $token = getToken(10);
 
       $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
       $select_user->execute([$email, $number]);
 
       if($select_user->rowCount() > 0){
          $warn_msg[] = 'Email or number already exists!';
      
             }else{
                $insert_user = $conn->prepare("INSERT INTO `users`(name, last_name, email, number, password, token) VALUES(?,?,?,?,?,?)");
                $insert_user->execute([$name, $l_name, $email, $number,$cpass,$token]);
             
                $success_reg[] = 'Registered successfully, Activate your account!';
                
                include 'components/email.php';
             
             }
          }else{
             $warn_msg[] = 'Password is too short!';
          }
          
       }
 
   
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Hotel Bahia Subic</title>
   <link rel="icon" type="image/png"  href="images/small-logo.png">
   <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />


   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   <!-- <div class="reg">
   <form class="form" action="" method="post">
    <p class="title">Register </p>
    <p class="message">Signup now and get full access to our website. </p>
        <div class="flex">
        <label>
            <input required="" placeholder="" type="text" name="last_name" class="input">
            <span>Last name</span>
        </label>

        <label>
            <input required="" placeholder="" type="text" name="first_name" class="input">
            <span>First name</span>
        </label>
    </div>  
            
    <label>
        <input required="" placeholder="" type="email" name="email" class="input">
        <span>Email</span>
    </label> 
        
    <label>
        <input required="" placeholder="" type="password" name="password" class="input">
        <span>Password</span>
    </label>
    <label>
        <input required="" placeholder="" type="password" name="cpassword" class="input">
        <span>Confirm password</span>
    </label>
    <input type="submit" name="submit" value="register now" class="submit">
    <p class="signin">Already have an acount ?<a href="login.php">Signin</a> </p>
</form>
</div> -->

<section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <a href="login.php" class="fa fa-close"></a>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/register.jpg" height="590" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <form action="" method="post" class="needs-validation" id="myForm">
                        <input id="RegiName" required="" placeholder="Enter your first name" type="text" name="name"  class="input">
                        <input id="RegiName" required="" placeholder="Enter your last name" type="text" name="l_name"  class="input">
                        <input id="RegiEmailAddres"  type="email" required="" placeholder="Enter your email address"  name="email" class="input">
                        <input id="RegiNumber" type="number" name="number" required="" placeholder="Enter your number" oninput="this.value=this.value.slice(0,this.maxLength)" maxlength="11" class="input">
                        <!-- <input id="RegiAddress" type="text" placeholder="Enter your Address" required="" maxlength="99" name="address" class="box form-control"> -->
                        <input id="RegiPassword" type="password" id="pass" name="pass" required="" placeholder="Enter your password" class="input">
                        <input id="RegiConfirmPassword" type="password" name="cpass" required="" placeholder="Confirm your password"  class="input">
                        <br>
                        
                        <label class="custom-checkbox">
                        <input type="checkbox" id="checkbox" required>
                        <span class="checkmark"></span>
                        <span class="label-text">Agree to </span>
                        </label>
                       <!-- Link trigger -->
                    <a href="#" id="termsLink">Terms and Conditions</a>

                    <!-- Modal -->
                    <div class="modal" id="termsModal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Terms and Conditions</h2><br>
                        <h2>TERMS AND CONDITIONS OF BAHIA HOTEL ROOM RESERVATION <h2> <br>
<p>
Please read these Terms and Conditions carefully before using the Bahia Hotel room reservation system. By making a reservation through the system, you agree to comply with these terms. If you do not agree with any part of these terms, please refrain from using the reservation system.
<br>
1. Reservation Process:<br>
   a. The Bahia Hotel room reservation system allows users to check availability, select desired dates, and book hotel rooms online.
   <br> b. By using the reservation system, you confirm that you are authorized to make reservations and provide the necessary information.
   <br>
2. Accuracy of Information:<br>
   a. You are responsible for providing accurate and up-to-date information during the reservation process.
   <br>b. Bahia Hotel reserves the right to cancel or modify a reservation if it is determined that false or misleading information has been provided.
   <br>
3. Reservation Confirmation:<br>
   a. A reservation made through the Bahia Hotel room reservation system is considered confirmed once you receive a confirmation email or reference number.
   <br> b. The confirmation email/reference number should be presented upon check-in at the hotel.
   <br>
4. Payment and Cancellation Policy:<br>
   a. The payment for the room reservation is subject to the policies specified during the reservation process.
   <br>b. Cancellation or modification of a reservation may be subject to fees or penalties as outlined in the reservation system or the hotel's cancellation policy.
   <br>
5. Reservation Changes:<br>
   a. Changes to a confirmed reservation, such as date modifications or room type changes, are subject to availability and any applicable fees.
   <br>b. Requests for reservation changes should be made through the reservation system or by contacting the hotel directly.
   <br>
6. No-Show Policy:<br>
   a. If you fail to check in on the scheduled arrival date without prior notice, it may be considered a no-show.
   <br>b. No-shows may result in the cancellation of the remaining reservation and may be subject to charges as per the hotel's policy.
   <br>
7. User Responsibilities:<br>
   a. Users of the reservation system are responsible for maintaining the confidentiality of their login credentials and ensuring the security of their account.
   <br>b. Any actions or reservations made using a user's account will be deemed the responsibility of the account holder.
   <br>
8. Limitation of Liability:<br>
   a. Bahia Hotel and its affiliates shall not be liable for any direct, indirect, incidental, consequential, or punitive damages arising from the use of the reservation system or any errors or inaccuracies in the system.
   <br>
9. Governing Law:<br>
   a. These terms and conditions shall be governed by and construed in accordance with the laws of the jurisdiction where Bahia Hotel is located.
   <br>
10. Modification of Terms:<br>
    a. Bahia Hotel reserves the right to modify or update these Terms and Conditions at any time without prior notice. The updated terms will be effective upon posting on the reservation system.
    <br>
By using the Bahia Hotel room reservation system, you acknowledge that you have read, understood, and agreed to these Terms and Conditions. If you have any questions or concerns, please contact our customer service or the hotel directly.</p>
                        <div class="modal-body">
                        <!-- Insert your terms and conditions content here -->
                        </div>
                    </div>
                    </div>
                        
                        <button  onclick="return ValidateRegistrationForm();" name="submit" id="RegistrationitBtn" class="btn" type="submit">Register</button>
                        </form>
                        <div id="message"></div>
                        
                        <div class="social-icons">
                            <p>Have an account? <a href="login.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
   


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'includes/alers.php' ?>
<script src="js/script.js"></script>
<script src="js/validation.js"></script>
<script src="js/jqBootstrapValidation.js"></script>
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>




<script src="js/jquery.min.js"></script>

<script>
    // Open modal when link is clicked
document.getElementById("termsLink").addEventListener("click", function() {
  document.getElementById("termsModal").style.display = "block";
});

// Close modal when close button or outside modal is clicked
document.getElementsByClassName("close")[0].addEventListener("click", function() {
  document.getElementById("termsModal").style.display = "none";
});

window.addEventListener("click", function(event) {
  var modal = document.getElementById("termsModal");
  if (event.target == modal) {
    modal.style.display = "none";
  }
});

document.getElementById("myForm").addEventListener("submit", function(event) {
  var checkbox = document.getElementById("checkbox");
  var message = document.getElementById("message");

  if (!checkbox.checked) {
    message.textContent = "Please check the checkbox.";
    message.style.color = "red";
    event.preventDefault();
  } else {
    message.textContent = "";
  }
});


</script>


    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>
</body>
</html>