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
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    $status = '';
    $deac = '';
 
    if(is_array($row)) {
       $status = $row['confirmation'];
       $deac = $row['deactive'];
    }
 
    if($deac == 0){
       if($status == 0){
          $warn_msg[] = 'Your account was not verified check your email for verification';
       }else{
          if($select_user->rowCount() > 0){
             $_SESSION['user_id'] = $row['id'];
             header('location:index.php');
          }else{
             $warn_msg[] = 'Incorrect username or password!';
          }
       }
    }else{
       $warn_msg[] = 'Incorrect username or password!';
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
                        <a href="index.php" class="fa fa-close"></a>
                    </div>
                    <div class="w3l_form align-self">   
                         <img src="images/login.jpg" height="500" alt="">
                       
                    </div>
                    <div class="content-wthree">
                        <h2>Login Now</h2>
                        <? $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <input type="password" class="password" name="pass" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
                            <button name="submit" name="submit" class="btn" type="submit">Login</button>
                        </form>
                        
                        <div class="social-icons">
                        <p>Don't have an account? <a href="forgotpass.php">Forget Password?</a></p>

                            <p>Create Account! <a href="register.php">Register</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>



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
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>


</body>
</html>