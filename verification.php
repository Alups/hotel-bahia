<?php

include 'includes/db.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

$output = "";

if($_GET){
    if(isset($_GET['email'])){
        $email = $_GET['email'];
        if($email == ''){
            unset($email);
        }
    }
    if(isset($_GET['token'])){
        $token = $_GET['token'];
        if($token == ''){
            unset($token);
        }
    }
    if(!empty($email) && !empty($token)){
        $select = $conn->prepare("SELECT id FROM users WHERE email=:email AND token=:token");
        $select->execute(array(
            'email' => $email,
            'token' => $token
        ));

            if($select->fetchColumn() > 0){
                $update = $conn->prepare("UPDATE users SET confirmation=1, token='' WHERE email=:email");
                $update->execute(array(
                    'email' => $email
                ));
                $output = 1;
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
                    <section class="verify">

<?php 
    if($output == 1){
?>
    <h1>YOUR EMAIL IS NOW VERIFIED</h1>
    <br>
    <a href="login.php"><h1>WELCOME, CLICK HERE TO LOG IN</h1></a>
<?php 
    }else{
?>
    <h1>CHECK YOUR EMAIL FOR EMAIL VERIFICATION</h1>
<?php 
    }
?>

</section>
                        <div class="social-icons">
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

</body>
</html>