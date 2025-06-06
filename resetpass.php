<?php

include 'includes/db.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};



if (isset($_GET['email'])) {
    $email = $_GET['email'];
    // Validate and sanitize the $email variable as needed

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the form is submitted

        // Retrieve the new password and confirm password values from $_POST
        $new_pass = sha1($_POST['new_pass']);
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

        $confirm_pass = sha1($_POST['confirm_pass']);
        $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);


        // Validate and sanitize the $new_pass and $confirm_pass variables as needed

        // Perform password reset logic
        if ($new_pass === $confirm_pass) {
            // Assuming you have a database connection established ($conn)

            // Update the password in your database for the corresponding user with the given email
            $update_query = "UPDATE users SET password = ? WHERE email = ?";
            $update_statement = $conn->prepare($update_query);


            // Execute the update query
            $update_statement->execute([$new_pass, $email]);

            // Check if the update was successful
            if ($update_statement->rowCount() > 0) {
                // Password updated successfully
                $success_reset = 'Password reset successfully!';

echo '<script>alert("' . $success_reset . '");</script>';
            } else {
                // Password update failed
                $error_msg = 'Failed to reset the password. Please try again.';
            }
        } 
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

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css">

</head>
<body>


   <section class="verify">

    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <a href="login.php" class="fa fa-close"></a>
                    </div>
                    <div class="w3l_form align-self">   
                         <img src="images/login.jpg" height="500" alt="">
                       
                    </div>
                    <div class="content-wthree">
                        <h2>Reset your password</h2>
                        <? $msg; ?>
                        <form action="" method="post">
                            <input type="password" id="Password" id="pass" class="password" name="new_pass" placeholder="Enter new Password" style="margin-bottom: 2px;" required>
                            <input type="password" id="ConfirmPassword" class="password" name="confirm_pass" placeholder="confirm new Password" style="margin-bottom: 2px;" required>
                            <button onclick="return ValidateResetForm();" type="submit" value="update now" class="btn" name="submit">Submit</button>

                        </form>
                        <div id="message"></div>
                        
                       
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>

</section>

    <!-- <section class="form-container login">

   <form action="" method="post">
      <h3>Forget Password</h3>
      <span>Enter your email address</span>
      <input type="email" name="email" required placeholder="Enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Send" class="btn" name="submit">
      <a href="user_login.php" class="option-btn">Back</a>
   </form>

</section> -->




<!-- <div class="form-container">

   <form action="" method="post" class="">
      
      <h3>login now</h3>
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="submit" name="submit" value="login now" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
      
   </form>

</div> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'includes/alers.php' ?>
<script src="js/validation.js"></script>
<script src="js/jqBootstrapValidation.js"></script>
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>



</body>
</html>