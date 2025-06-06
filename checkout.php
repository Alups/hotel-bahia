<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $order_no = $_POST['order_no'];
   $order_no = filter_var($order_no, FILTER_SANITIZE_STRING);
   $fee = $_POST['fee'];
   $fee = filter_var($fee, FILTER_SANITIZE_STRING);
   $method = $_POST['collapseGroup'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $pids = $_POST['pids'];
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $proof = $order_no.'_proof.' . pathinfo($_FILES['img_prof']['name'],PATHINFO_EXTENSION);
   $proof = filter_var($proof, FILTER_SANITIZE_STRING);
   $image_tmp_name = $_FILES['img_prof']['tmp_name'];
   $image_folder = 'uploaded_img/proof/'.$proof;

   if($proof == $order_no.'_proof.'){
      $proof = 'COD';

      $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $check_cart->execute([$user_id]);
     
        if($check_cart->rowCount() > 0){
     
              $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, order_no, fee, pids) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
              $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $order_no, $fee, $pids]);

              $insert_pro = $conn->prepare("UPDATE `orders` SET proof = ? WHERE email = ?");
              $insert_pro->execute([$proof, $email]);

              $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
              $delete_cart->execute([$user_id]);
     
              $success_checkout[] = 'Your order placed successfully!';
            }else{
               $info_img[] = 'Your cart is empty';
            }
   }else{

      $allowed = array('png', 'jpg', 'jpeg', 'webp', 'JPG');
      $ext = pathinfo($proof, PATHINFO_EXTENSION);

      if (!in_array($ext, $allowed)) {
         $warning_msg[] = 'Only png, jpg, jpeg and webp are allowed!';
      }else{
         if($_FILES['img_prof']['size'] > 2000000){
            $warning_msg[] = 'File size is too large!';
         }else{
           //img file all checked
           $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
           $check_cart->execute([$user_id]);
        
           if($check_cart->rowCount() > 0){
        
                 $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, proof, address, total_products, total_price, order_no, fee, pids) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                 $insert_order->execute([$user_id, $name, $number, $email, $method, $proof, $address, $total_products, $total_price, $order_no, $fee, $pids]);
                  
                 move_uploaded_file($image_tmp_name, $image_folder);
   
                 $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                 $delete_cart->execute([$user_id]);
        
                 $success_checkout[] = 'Your order placed successfully!';
        
           }else{
              $info_img[] = 'Your cart is empty';
           }
   
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Hotel Bahia Subic</title>
<link rel="icon" type="image/png"  href="images/small-logo.png">

<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Resort Inn Responsive , Smartphone Compatible web template , Samsung, LG, Sony Ericsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/font-awesome.css" rel="stylesheet"> 
<link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen">
<link href="css/easy-responsive-tabs.css" rel='stylesheet' type='text/css'/>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" property="" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/modernizr-2.6.2.min.js"></script>
<!--fonts-->
<link href="//fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Federo" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<!--//fonts-->
</head>
<body>
   
<?php include 'includes/header.php'; ?>

<section class="reservation" id="reservation">


<form action="" method="post" enctype="multipart/form-data">
<div class="flex">
   <!-- <div class="box">
      <h3>cart items</h3>
      <?php
         $grand_total = 0;
         $address = "";
         $fee = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].'), ';
               $total_products = implode($cart_items);
               $car_itemsId[] = $fetch_cart['pid'].',';
               $prod_ids = implode($car_itemsId);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
               $sum = $fetch_cart['price'] * $fetch_cart['quantity'];
               $order_no = mt_rand(100000,999999);
               $address = $fetch_cart['address'];
               $fee = $fetch_cart['fee'];
      ?>
      <p class="total-number"><span class="name"><?= $fetch_cart['name']; ?></span><span class="price"><span>&#8369</span><?= number_format($fetch_cart['price'], 2, '.', ','); ?> x <?= $fetch_cart['quantity']; ?> = <?= number_format($sum, 2, '.', ',')?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
         $grand_total = $grand_total + $fee;
         $gt = number_format($grand_total, 2, '.', ',');
         $dfee = number_format($fee, 2, '.', ',');
      ?>
      <p class="total-number"><span class="name">DELIVERY FEE: </span><span class="price"><span>&#8369</span><?= $dfee ?></span></p>
      <p class="grand-total"><span class="grandt">Grand total :</span><span class="price"><span>&#8369</span><?php echo $gt ?></span></p>
      <a href="cart.php" class="btn">view cart</a>
   </div> -->

   <input type="hidden" name="pids" value="<?= $prod_ids; ?>">
   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="fee" value="<?= $fee ?>">
   <input type="hidden" name="address" value="<?= $address ?>">
   <input type="hidden" name="order_no" value="<?= $order_no ?>">

   <div class="box">
      <h3>your info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="profile.php" class="btn">update info</a>
      <h3>delivery address</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?= $address ?></span></p>
      <h3>Payment method</h3>
      <p><i class="fas fa-truck"></i>
      <input name="collapseGroup" type="radio" class='gcash'value="GCASH"/> GCASH
      <input name="collapseGroup" type="radio" class='cod' value="COD" checked/> COD
      </p>
      <div id="gcashs" class="panel-collapse collapse">
         <p>GCASH Number: 09260917344</p>
         <p>GCASH Name: Ferlin G.</p>
         <h1>Upload proof of payment</h1>
         <div class="inputBox">
            <input type="file" name="img_prof" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
            <span>Image <i class="notice">* file size must be 2MB below</i></span>
         </div>
      </div>
  
      <input type="submit" value="place order" class="btn <?php if($total_products == ''){echo 'disabled';} ?>" name="submit">
   </div>
   </div>   

</form>
   
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="js/script.js"></script>
<script>
$(document).ready(function () {
   $('#gcashs').hide();

   $('.gcash').click(function(){
      $('#gcashs').show(); 
   });

   $('.cod').click(function(){
      $('#gcashs').hide(); 
   });
});
  
</script>

<?php include 'components/alers.php'; ?>

</body>
</html>