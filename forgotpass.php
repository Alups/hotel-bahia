<?php

include 'includes/db.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

$msg = "";

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);

   function getToken($len=32){
    return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
    }

    $token = getToken(10);

    if($select_user->rowCount() > 0){
        $update_user = $conn->prepare("UPDATE `users` SET token = ? WHERE email = ?");
        $update_user->execute([$token, $email]);

        include 'components/forgetemail.php';
        
     }else{
        $warning_msg[] = "Email not found!";
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
   <div class="reg">
   <!-- <form class="form" action="" method="post">
    <p class="title">Login </p>
            
    <label>
        <input required="" placeholder="" type="email" name="email" class="input">
        <span>Email</span>
    </label> 
        
    <label>
        <input required="" placeholder="" type="password" name="password" class="input">
        <span>Password</span>
    </label>

    <input type="submit" name="submit" value="Login" class="submit">
  
    <p class="signin">don't have an account? <a href="register.php">register now</a></p>
</form> -->

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
                    <h3>Forgot Password</h3>
                      <? $msg; ?>
                      
                        <form action="" method="post">
                        <input type="email" name="email" required placeholder="Enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                            <button name="submit" name="submit" class="btn" type="submit">SUBMIT</button>
                        </form>
                        
                        <div class="social-icons">

                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
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

</body>
</html>