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

<header class="header">

   <section class="flex">
      <a href="index.php" class="logo"><img class="mainlogo" src="images/logo.png" alt="xmts_logo"/></a>

      <nav class="navbar">
         <a href="index.php">Home</a>
         <a href="shop.php">Products</a>
         <?php 
            if(isset($_SESSION['user_id'])){
               $user_id = $_SESSION['user_id'];
               echo '<a href="orders.php">Orders</a>';
            }else{
               $user_id = '';
               echo '<a href="orders.php" hidden>>Orders</a>';
            };
         ?>
         <a href="about.php">About</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <!-- <a href="search_page.php"><i class="fas fa-search"></i></a> -->
         <!-- <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a> -->
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="text-capitalize">Hi <?= $fetch_profile["name"]; ?>!</p>
         
         <div>
            <?php if(empty($fetch_profile['image'])){
               echo '';
            }else{
               echo '<img src="uploaded_img/profiles/'.$fetch_profile['image'].'">';
            }?>
            
            <a href="profile.php" class="btn">profile</a>
            <button type="button" class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal">Logout</button>
         </div>

         <div class="modal expand" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content z-3">
               <img src="images/warning.png" class="img-fluid rounded mx-auto d-block" alt="">
               <div class="modal-body text-center border-0">
               <h1>Are you sure you want logout?</h1>
               </div>
               <div class="modal-footer justify-content-center text-center border-0">
               <button  class="btnm btn-delete-cancel" data-bs-dismiss="modal">Cancel</button>
               <a href="components/user_logout.php" class="btnm btn-delete-yes">Yes</a>
               </div>
            </div>
         </div>
         </div>

        
         <?php
            }else{
         ?>
         <p>Please login or register first!</p>
         <div class="flex-btn">
            <a href="user_register.php" class="option-btn">register</a>
            <a href="user_login.php" class="option-btn">login</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>
<script src="/library/bootstrap-5/bootstrap.bundle.min.js"></script>