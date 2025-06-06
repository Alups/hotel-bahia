<?php

include 'includes/db.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};





if(isset($_POST['book'])){

   $booking_id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $rooms = $_POST['rooms'];
   $rooms = filter_var($rooms, FILTER_SANITIZE_STRING);
   $check_in = $_POST['check_in'];
   $check_in = filter_var($check_in, FILTER_SANITIZE_STRING);
   $check_out = $_POST['check_out'];
   $check_out = filter_var($check_out, FILTER_SANITIZE_STRING);
   $adults = $_POST['adults'];
   $adults = filter_var($adults, FILTER_SANITIZE_STRING);
   $childs = $_POST['childs'];
   $childs = filter_var($childs, FILTER_SANITIZE_STRING);
   $room_category = $_POST['room_category'];
   $room_category = filter_var($room_category, FILTER_SANITIZE_STRING);
   $method = $_POST['collapseGroup'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $room_price = $_POST['room_price'];
   $room_price = filter_var($room_price, FILTER_SANITIZE_STRING);
   

   $total_rooms = 0;

   $check_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE check_in = ?");
   $check_bookings->execute([$check_in]);
   
   while($fetch_bookings = $check_bookings->fetch(PDO::FETCH_ASSOC)){
      $total_rooms += $fetch_bookings['rooms'];
   }

   $proof = $booking_id.'_proof.'. pathinfo($_FILES['img_prof']['name'],PATHINFO_EXTENSION);
   $proof = filter_var($proof, FILTER_SANITIZE_STRING);
   $image_tmp_name = $_FILES['img_prof']['tmp_name'];
   $image_folder = 'uploaded_img/proof/'.$proof;

   if($proof == $booking_id.'_proof.'){
      // fucking PUCI
      $proof = 'PAYUPONCHECKIN';

      if($total_rooms >= 30){
      $warn_msg[] = 'rooms are not available';
      }else{

         $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND name = ? AND email = ? AND number = ? AND rooms = ? AND check_in = ? AND check_out = ? AND adults = ? AND childs = ? AND category = ? AND price = ?");
         $verify_bookings->execute([$user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs, $room_category, $room_price]);

         if($verify_bookings->rowCount() > 0){
            $warn_msg[] = 'room booked alredy!';
         }else{
            $book_room = $conn->prepare("INSERT INTO `bookings`(booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, category, proof, method, price) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $book_room->execute([$booking_id, $user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs ,$room_category,$proof,$method, $room_price]);
            
            $room_status_update = $conn->prepare("UPDATE `rooms` SET `status` = 'Occupied' WHERE `name` = ?");
            $room_status_update->execute([$rooms]);

            // $payment_update= $conn->prepare("UPDATE `bookings` SET `payment_status` = 'Not Paid' WHERE `method` = ?");
            // $payment_update->execute([$method]);


            
            $success_book[] = 'room booked successfully!';

            include 'components/booking_id.php';
         }

      }

   }else{
      // GCASH TO
      $allowed = array('png', 'jpg', 'jpeg', 'webp', 'JPG');
      $ext = pathinfo($proof, PATHINFO_EXTENSION);

      if (!in_array($ext, $allowed)) {
         $warning_msg[] = 'Only png, jpg, jpeg and webp are allowed!';
      }else{
         if($_FILES['img_prof']['size'] > 2000000){
            $warning_msg[] = 'File size is too large!';
         }else{
            // ALL GOODDDS NA BITCH

            if($total_rooms >= 30){
               $warning_msg[] = 'rooms are not available';
               }else{
         
                  $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND name = ? AND email = ? AND number = ? AND rooms = ? AND check_in = ? AND check_out = ? AND adults = ? AND childs = ? AND category = ? AND price = ?");
                  $verify_bookings->execute([$user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs, $room_category, $room_price]);
         
                  if($verify_bookings->rowCount() > 0){
                     $warning_msg[] = 'room booked alredy!';
                  }else{

                     move_uploaded_file($image_tmp_name, $image_folder);
                     $book_room = $conn->prepare("INSERT INTO `bookings`(booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, category, proof, method, price) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                     $book_room->execute([$booking_id, $user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs , $room_category, $proof, $method, $room_price]);
                     
                     $room_status_update = $conn->prepare("UPDATE `rooms` SET `status` = 'Occupied' WHERE `name` = ?");
                     $room_status_update->execute([$rooms]);

                     // $payment_update= $conn->prepare("UPDATE `bookings` SET `payment_status` = 'Paid' WHERE `method` = ?");
                     // $payment_update->execute([$method]);

                     $success_msg[] = 'room booked successfully!';

                     include 'components/booking_id.php';

                    
                  }
         
               }

         }
      }
   }

   

}

if(isset($_POST['send'])){

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $message = $_POST['message'];
   $message = filter_var($message, FILTER_SANITIZE_STRING);

   $verify_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $verify_message->execute([$name, $email, $number, $message]);

   if($verify_message->rowCount() > 0){
      $warning_msg[] = 'message sent already!';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$id, $name, $email, $number, $message]);
      $success_msg[] = 'message send successfully!';
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

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
   <link rel="script" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"/>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/checkin.css">

</head>
<body>




<!-- services section ends -->

<!-- reservation section starts  -->

<section class="reservation" id="reservation">

    <?php
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $parts = parse_url($url);
    parse_str($parts['query'], $query);
    $room_id = $query['id'];

    $select_cat = $conn->prepare("SELECT * FROM `category` WHERE id = ?");
    $select_cat->execute([$room_id]);

    if ($select_cat->rowCount() > 0) {
        $fetch_products = $select_cat->fetch(PDO::FETCH_ASSOC);
        $room_category = $fetch_products['name'];

        $select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE category = ? AND status = 'available' LIMIT 1");
        $select_rooms->execute([$room_category]);

        if ($select_rooms->rowCount() > 0) {
            $fetch_room = $select_rooms->fetch(PDO::FETCH_ASSOC);
            $roomName = $fetch_room['name'];
            $roomPrice = $fetch_room['price'];
            $roomId = $fetch_room['id'];

            $select_user = $conn->prepare("SELECT * FROM `users` WHERE  id = ?");
            $select_user->execute([$user_id]);

            if ($select_user->rowCount() > 0) {
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>make a reservation</h3>
                    <div class="flex">
                        <div class="box">
                            <p>NAME</p>
                            <input type="text" name="name" maxlength="50" required placeholder="enter your name"
                                   class="input" value="<?php echo $fetch_user['name'] ?>">
                        </div>
                        <div class="box">
                            <p>EMAIL ADDRESS<span></p>
                            <input type="email" name="email" maxlength="50" required placeholder="enter your email"
                                   class="input" value="<?php echo $fetch_user['email'] ?>">
                        </div>
                        <div class="box">
                            <p>CONTACT NUMBER</p>
                            <input type="number" name="number" maxlength="10" min="0" max="9999999999" required
                                   placeholder="enter your number" class="input"
                                   value="<?php echo $fetch_user['number'] ?>">
                        </div>
                        <div class="box">
                            <p>ROOM NUMBER</p>

                            <select name="rooms" class="input" required>
    <?php
    $wildcardCategory = '%' . trim($room_category) . '%';
    $select_room = $conn->prepare("SELECT * FROM `rooms` WHERE `category` LIKE :category AND `status` = 'available'");
    $select_room->bindValue(':category', $wildcardCategory);
    $select_room->execute();

    if ($select_room->rowCount() > 0) {
        while ($fetch_room = $select_room->fetch(PDO::FETCH_ASSOC)) {
            $roomName = $fetch_room['name'];
            $roomId = $fetch_room['id'];
            echo "<option value=\"$roomName\">$roomName</option>";
        }
    }
    ?>
</select>                        </div>
                        <div class="box">
                            <p>CHECK IN <span>*</span></p>
                            <input type="date" id="check_in" name="check_in" class="input" required>
                        </div>
                        <div class="box">
                            <p>CHECK OUT<span>*</span></p>
                            <input type="date" id="check_out" name="check_out" class="input" required>
                        </div>
                        <div class="box">
                            <p>ADULTS<span>*</span></p>
                            <select name="adults" class="input" required>
                                <option value="1" selected>1 adult</option>
                                <option value="2">2 adults</option>
                                <option value="3">3 adults</option>
                                <option value="4">4 adults</option>
                                <option value="5">5 adults</option>
                                <option value="6">6 adults</option>
                            </select>
                        </div>
                        <div class="box">
                            <p>CHILDREN <span>*</span></p>
                            <select name="childs" class="input" required>
                                <option value="0" selected>0 child</option>
                                <option value="1">1 child</option>
                                <option value="2">2 children</option>
                                <option value="3">3 children</option>
                                <option value="4">4 children</option>
                                <option value="5">5 children</option>
                                <option value="6">6 children</option>
                            </select>
                        </div>
                        <div class="box">
                            <p>TYPE OF ROOM<span>*</span></p>
                            <input readonly type="text" name="room_category" class="input"
                                   value="<?= $fetch_products['name'] ?>" required>
                        </div>
                        <div class="box">
                            <p>ROOM PRICE</p>
                            <input readonly type="text" name="room_price" class="input" value="<?= $fetch_products['price']?>" required>
                        </div>

                    </div>
                    <input name="collapseGroup" type="radio" class='gcash' value="ONLINEPAYMENT"/> ONLINE PAYMENT
                    <input name="collapseGroup" type="radio" class='cod' value="PAY UPON CHECK IN"
                           checked/> <p>PAY UPON CHECK IN
                    </p>
                    <div id="gcashs" class="panel-collapse collapse">

                        <img src="images/payment/1.png" class="proof" height="300" alt=""> 
                        <img src="images/payment/2.png" class="proof" height="300" alt="">
                        <img src="images/payment/3.png" class="proof" height="300" alt="">
                        <div class="inputBox">
                            <p>Upload proof of payment</p>
                            <input type="file" name="img_prof" accept="image/jpg, image/jpeg, image/png, image/webp"
                                   class="box">
                        </div>

                    </div>
                    <input type="submit" value="book now" name="book" class="btn">
                    <a href="index.php"><input value="Cancel" name="cancel" class="btn"></a>
                </form>

            <?php
            } else {
                echo '<p class="empty">no user found login first</p>';
            }
        } else {
            echo '<h1 class="empty">No Rooms available</h1>
         <a href="index.php" class="cancel"><input value="Back" name="cancel" class="btn"></a>';
        }
    }
    ?>

</section>


<!-- reservation section ends -->

<!-- gallery section starts  -->


<!-- reviews section ends  -->



<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');

        // Get the current date in yyyy-mm-dd format
        function getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Set the minimum date for the check-in input to the current date
        checkInInput.setAttribute('min', getCurrentDate());

        // Add an event listener to the check-in input to handle the check-out date limitation
        checkInInput.addEventListener('change', function() {
            checkOutInput.setAttribute('min', checkInInput.value);
            checkOutInput.value = ""; // Reset check-out value when check-in changes to avoid invalid selections.
        });

        // Set the minimum date for the check-out input to the check-in date initially
        checkOutInput.setAttribute('min', checkInInput.value);
    </script>
    

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
<?php include 'includes/alers.php'; ?>

</body>
</html>