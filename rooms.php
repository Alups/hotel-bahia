<?php

error_reporting(0);
session_start();



include('includes/db.php');

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};

if (isset($_POST['submit'])) {
    $checkInDate = $_POST['check_in'];
    $checkOutDate = $_POST['check_out'];
    $category = $_POST['room_category'];

    $combinedDates = $checkInDate . '/' . $checkOutDate;

    // Calculate dates between the check-in and check-out dates
    $startDate = new DateTime($checkInDate);
    $endDate = new DateTime($checkOutDate);
    $endDate->modify('+1 day'); // Include the end date itself
    $dateInterval = new DateInterval('P1D'); // Interval of 1 day
    $dateRange = new DatePeriod($startDate, $dateInterval, $endDate);

    // Get assigned rooms for the selected category
    $sql = "SELECT name, assigned_date FROM rooms WHERE category = :category";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category', $category);
    $stmt->execute();

    $assignedRooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $availableRoomCount = 0;

    foreach ($assignedRooms as $room) {
        $assignedDateRange = explode('/', $room['assigned_date']);
        $assignedStartDate = new DateTime($assignedDateRange[0]);
        $assignedEndDate = new DateTime($assignedDateRange[1]);

        $isAvailable = true;

        foreach ($dateRange as $date) {
            if ($date >= $assignedStartDate && $date <= $assignedEndDate) {
                $isAvailable = false;
                break;
            }
        }

        if ($isAvailable) {
            $availableRoomCount++;
        }
    }

    if ($availableRoomCount > 0) {
		$info_msg[] = "Rooms available on this date: $availableRoomCount";
    } else {
		$info_msg[] = "No available rooms for the selected category and dates.";
    }
}





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
	$total_price = $_POST['total_price'];
	$total_price = filter_var($total_price, FILTER_SANITIZE_STRING);
	$date_now = $_POST['date_now'];
	$date_now = filter_var($date_now, FILTER_SANITIZE_STRING);
	
	
 
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
 
		  $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND name = ? AND email = ? AND number = ? AND rooms = ? AND check_in = ? AND check_out = ? AND adults = ? AND childs = ? AND category = ? AND price = ? AND date_now = ?");
		  $verify_bookings->execute([$user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs, $room_category, $total_price, $date_now]);
 
		  if($verify_bookings->rowCount() > 0){
			 $warn_msg[] = 'room booked alredy!';
		  }else{
			 $book_room = $conn->prepare("INSERT INTO `bookings`(booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, category, proof, method, price, date_now) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			 $book_room->execute([$booking_id, $user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs ,$room_category,$proof,$method, $total_price, $date_now]);
			 
			//  $room_status_update = $conn->prepare("UPDATE `rooms` SET `status` = 'Occupied' WHERE `name` = ?");
			//  $room_status_update->execute([$rooms]);
 
			 // $payment_update= $conn->prepare("UPDATE `bookings` SET `payment_status` = 'Not Paid' WHERE `method` = ?");
			 // $payment_update->execute([$method]);
 
 
			 
			 $success_book[] = 'Your reservation is on process, please wait for the approval';
 
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
		  
				   $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND name = ? AND email = ? AND number = ? AND rooms = ? AND check_in = ? AND check_out = ? AND adults = ? AND childs = ? AND category = ? AND price = ? AND date_now = ?");
				   $verify_bookings->execute([$user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs, $room_category, $total_price, $date_now]);
		  
				   if($verify_bookings->rowCount() > 0){
					  $warning_msg[] = 'room booked alredy!';
				   }else{
 
					  move_uploaded_file($image_tmp_name, $image_folder);
					  $book_room = $conn->prepare("INSERT INTO `bookings`(booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, category, proof, method, price, date_now) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
					  $book_room->execute([$booking_id, $user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs , $room_category, $proof, $method, $total_price, $date_now]);
					  
					//   $room_status_update = $conn->prepare("UPDATE `rooms` SET `status` = 'Occupied' WHERE `name` = ?");
					//   $room_status_update->execute([$rooms]);
 
					  // $payment_update= $conn->prepare("UPDATE `bookings` SET `payment_status` = 'Paid' WHERE `method` = ?");
					  // $payment_update->execute([$method]);
 
					  $success_book[] = 'Your reservation is on process, please wait for the approval';
 
					  include 'components/booking_id.php';
 
					 
				   }
		  
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
<!-- Add this inside the head tag of your HTML -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!--fonts-->
<link href="//fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Federo" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!--//fonts-->
</head>
<body>

<div class="banner-top">
	<div class="clearfix"></div>
</div>
	<div class="w3_navigation">
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="navbar-header navbar-left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<h1><a class="navbar-brand" href="index.php">Hotel <span>Bahia</span><p class="logo_w3l_agile_caption">Subic</p></a></h1>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
             
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
        <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
					<nav class="menu menu--iris">
                        
					<ul class="nav navbar-nav menu__list">
							<li class="menu__item"><a href="index.php" class="menu__link">Home</a></li>
							<li class="menu__item"><a href="about.php" class="menu__link ">About</a></li>
					
							<li class="menu__item"><a href="#contact" class="menu__link scroll">Contact Us</a></li>
							<li class="menu__item"><a href="profile.php" class="menu__link">Profile</a></li>
							<li class="menu__item"><a href="logout.php" class="menu__link">Logout</a></li>
							<?php 
							}else{ 
							?>			

	
						</ul>
                        <ul class="nav navbar-nav menu__list">
							<li class="menu__item1"><a href="index.php" class="menu__link1">Home</a></li>
							<li class="menu__item1"><a href="about.php" class="menu__link1 ">About</a></li>
							<li class="menu__item1"><a href="#rooms" class="menu__link">Contact Us</a></li>
							<li class="menu__item"><a href="profile.php" class="menu__link">Profile</a></li>
		                	<li class="menu__item1"><a href="login.php" class="menu__link1">Login</a></li>
			 <?php
            }
         ?> 
						</ul>
					</nav>
				</div>
			</nav>

		</div>
	</div>

	<!-- <section class="photo-viewer" id="photo-viewer">
    <div class="container">
        <h3>Room overview</h3>
        <div class="photo-gallery">
            <div class="photo">
                <img src="images/1.jpg" alt="Photo 1">
            </div>
            <div class="photo">
                <img src="images/2.jpg" alt="Photo 2">
            </div>
            <div class="photo">
                <img src="images/3.jpg" alt="Photo 3">
            </div>
        </div>
    </div>
</section>
 -->










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

        $select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE category = ? LIMIT 1");
        $select_rooms->execute([$room_category]);

        if ($select_rooms->rowCount() > 0) {
            $fetch_room = $select_rooms->fetch(PDO::FETCH_ASSOC);
            $roomName = $fetch_room['name'];
            $roomId = $fetch_room['id'];

            $select_user = $conn->prepare("SELECT * FROM `users` WHERE  id = ?");
            $select_user->execute([$user_id]);

            if ($select_user->rowCount() > 0) {
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
                ?>
	<form action="" method="post" enctype="multipart/form-data" class="reservation-form">
    <h3>Make a Reservation</h3>
    <div class="form-group">
        <!-- <label for="name">Name</label> -->
        <input type="text" hidden name="name" id="name" maxlength="50" required value="<?php echo $fetch_user['name'] . ' ' . $fetch_user['last_name']; ?>">
    </div>
	<div class="form-group">
        <!-- <label for="name">Name</label> -->
		<input type="text" hidden  name="date_now" id="date_now" maxlength="50" required value="">
    </div>
    <div class="form-group">
        <!-- <label for="email">Email Address</label> -->
        <input type="email" hidden name="email" id="email" maxlength="50" value="<?php echo $fetch_user['email'] ?>">
    </div>
    <div class="form-group">
        <!-- <label for="number">Contact Number</label> -->
        <input type="number" hidden name="number" id="number" maxlength="10" min="0" max="9999999999" value="<?php echo $fetch_user['number'] ?>">
    </div>
	<div class="date-input-container">
  <div class="form-group">
    <label for="check_in">Check-in Date</label>
    <input type="date" id="check_in" name="check_in" required>
  </div>
  <div class="form-group">
    <label for="check_out">Check-out Date</label>
    <input type="date" id="check_out" name="check_out" required>
  </div>
  <div class="form-group">
<br>
<input type="submit" class="btn" id="submit" name="submit" value="Check Available Room" required>
  </div>
</div>

    <div class="form-group">
        <label for="rooms">Number of Room</label>
		<input type="number" id="number_of_rooms" name="rooms" min="1" required placeholder="Enter number of rooms" value="1" oninput="calculateTotalPrice()">

    </div>
	

	<div class="form-group">
    <label for="adults">Adults<span class="question-mark" onclick="showTooltip()"> <i class="fas fa-question-circle"></i></span></label>
    <div id="tooltip" class="hidden"></div>

	<select name="adults" id="adultsSelect" onchange="updateChildrenOptions()" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
	</div>

	<div class="form-group">
		<label for="childs">Children<span class="question-mark" onclick="showTooltip1()"> <i class="fas fa-question-circle"></i></span></label>
		<div id="tooltip1" class="hidden">Children 10 y/o below are free charge. 11 y/o considered as an Adult.</div>

		<select name="childs" id="childs" onchange="updateAdultsOptions()" required>
		<option value="0" selected>0 child</option>
        <option value="1">1 child</option>
			<!-- Other options will be added dynamically based on the number of adults selected -->
		</select>
	</div>

	<div class="date-input-container">
  <div class="form-group">
    <label for="bed">Additional Bed<span class="question-mark" onclick="showTooltip2()"> <i class="fas fa-question-circle"></i></span></label>
	<div id="tooltip2" class="hidden">Extra bed charge will be ₱500/bed</div>

	<select name="bed" id="bed" required>
		<option value="0" selected>0</option>
        <option value="1">1</option>
        <option value="2">2</option>
    </select>  
	</div>
  		<div class="form-group">
    <label for="pillow">Additional Pillow<span class="question-mark" onclick="showTooltip3()"> <i class="fas fa-question-circle"></i></span></label>
	<div id="tooltip3" class="hidden">Additional 2 pillows will be Free of charge, exceeding will be charge of  ₱100/pillows</div>

	<select name="pillow" id="pillow" required>
		<option value="0" selected>0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>  
		</div>
	</div>
	
    <div class="form-group">
        <label for="room_category">Type of Room</label>
        <input readonly type="text" name="room_category" id="room_category" value="<?= $fetch_products['name']?>" required>
    </div>

	<div class="form-group">
		<input type="number" hidden id="number_of_nights" name="number_of_nights" readonly>
	</div>
<br>
	<div class="form-group">
		<p id="number_of_rooms_text"></p>
		<p id="number_of_nights_text"></p>
		<p id="additional_person_text"></p>
		<p id="additional_bed_text"></p>
		<p id="additional_pillow_text"></p>
		<p class="price" id="total_price_text"></p>

	</div>


	<div class="form-group">
		<p  for="room_category"></p>
		<input hidden readonly type="text" id="total_price_input" name="total_price" required>
	</div>


    <div class="payment-options">
        <label>Payment Method:</label>
		<br>
		<input name="collapseGroup" type="radio" value="" class='gcash'/> ONLINE PAYMENT
                    <input name="collapseGroup" type="radio" class='cod' value="PUCI"
                           checked/>PAY UPON CHECK IN
                 					
    </div>
    <div id="gcashs" class="panel-collapse collapse">
        <div class="form-group">
			<!-- <p>Scan the qr code of your selected online payment method and upload a proof of payment</p> -->
			<select  id="imageSelect" onchange="showSelectedImage()">
			<option value="Gcash" >Gcash</option>
			<option value="AliPay">AliPay</option>
			<option value="UnionPay">UnionPay</option>
		</select>


		<img src="images/payment/Gcash.png" class="proof" height="300" alt="" style="display: none">
		<img src="images/payment/AliPay.png" class="proof" height="300" alt="" style="display: none">
		<img src="images/payment/UnionPay.png" class="proof" height="300" alt="" style="display: none">



	</div>
        <div class="form-group">
            <label for="img_prof">Upload Proof of Payment</label>
            <input type="file" name="img_prof" id="img_prof" accept="image/jpg, image/jpeg, image/png, image/webp">
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="Book Now" name="book" class="btn">
        <a href="index.php" class="btn cancel">Cancel</a>
    </div>
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

   
	
	
<section class="contact-w3ls" id="contact">
	<div class="container">
		<div class="col-lg-6 col-md-6 col-sm-6 contact-w3-agile2" data-aos="flip-left">
			<div class="contact-agileits">
				<h4>Contact Us</h4>
				<p class="contact-agile2">Sign Up For Our News Letters</p>
				<form  method="post" name="sentMessage" id="contactForm" >
					<div class="control-group form-group">
                        
                            <label class="contact-p1">Full Name:</label>
                            <input type="text" class="form-control" name="name" id="name" required >
                            <p class="help-block"></p>
                       
                    </div>	
                    <div class="control-group form-group">
                        
                            <label class="contact-p1">Phone Number:</label>
                            <input type="tel" class="form-control" name="phone" id="phone" required >
							<p class="help-block"></p>
						
                    </div>
                    <div class="control-group form-group">
                        
                            <label class="contact-p1">Email Address:</label>
                            <input type="email" class="form-control" name="email" id="email" required >
							<p class="help-block"></p>
						
                    </div>
                    
                    
                    <input type="submit" name="sub" value="Send Now" class="btn btn-primary">	
				</form>
				<?php
				if(isset($_POST['sub']))
				{
					$name =$_POST['name'];
					$phone = $_POST['phone'];
					$email = $_POST['email'];
					$approval = "Not Allowed";
					$sql = "INSERT INTO `contact`(`fullname`, `phoneno`, `email`,`cdate`,`approval`) VALUES ('$name','$phone','$email',now(),'$approval')" ;

					if(mysqli_query($con,$sql))
					echo"OK";

				}
				?>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 contact-w3-agile1" data-aos="flip-right">
			<h4>Connect With Us</h4>
			<p class="contact-agile1"><strong>Phone :</strong>(047) 252 2894</p>
			<p class="contact-agile1"><strong>Email :</strong> <a>info@hotelbahiasubicbay.com</a></p>
			<p class="contact-agile1"><strong>Address :</strong>Bldg. 664 Waterfront Rd cor McKinley St, Subic Bay Freeport Zone, Olongapo, Philippines, 2222</p>
			<div class="social-bnr-agileits footer-icons-agileinfo">
				<ul class="social-icons3">
								<li><a href="https://www.facebook.com/hotelbahiasubicbay" class="fa fa-facebook icon-border facebook"> </a></li>
								<li><a href="#" class="fa fa-twitter icon-border twitter"> </a></li>
								<li><a href="#" class="fa fa-google-plus icon-border googleplus"> </a></li> 
							</ul>
			</div>
			<div style="width: 100%">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3857.0873817358624!2d120.27162408066799!3d14.820353134788705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396711493025b21%3A0x2b9ffce105989d99!2sHotel%20Bahia%20Subic%20Bay!5e0!3m2!1sen!2sph!4v1686727367941!5m2!1sen!2sph" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
		<div class="clearfix"></div>
	</div>
</section>
<!-- /contact -->
		
<!--/footer -->
<!-- js -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="/library/bootstrap-5/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<!-- contact form -->
<script src="js/jqBootstrapValidation.js"></script>

<!-- /contact form -->	
<!-- Calendar -->

<script src="js/jquery-ui.js"></script>
<script>
  const radioInput = document.querySelector('.gcash');
  const selectElement = document.getElementById('imageSelect');

  // Add event listener to the radio button to update the selected value of the select element
  radioInput.addEventListener('click', function() {
    selectElement.value = radioInput.value;
  });

  // Add event listener to the select element to update the value of the radio button
  selectElement.addEventListener('change', function() {
    radioInput.value = selectElement.value;
  });
</script>


<script>
function showSelectedImage() {
    const imageSelect = document.getElementById('imageSelect');
    const selectedValue = imageSelect.value;
    const images = document.querySelectorAll('.proof');

    // Hide all images
    images.forEach(image => {
        image.style.display = 'none';
    });

    // Display the selected image
    const selectedImage = document.querySelector(`.proof[src="images/payment/${selectedValue}.png"]`);
    if (selectedImage) {
        selectedImage.style.display = 'block';
    }
}

</script>

<script>
 function updateChildrenOptions() {
        const adultsSelect = document.getElementById('adultsSelect');
        const childsSelect = document.getElementById('childs');
        const selectedAdults = parseInt(adultsSelect.value);
        const maxChildren = 5 - selectedAdults; // Limit number of children options based on selected adults

        // Clear existing options in the children select element
        childsSelect.innerHTML = "";

        // Add the new options based on the number of adults selected
        for (let i = 0; i <= maxChildren; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i === 0 ? "0 child" : `${i} ${i === 1 ? "child" : "children"}`;
            childsSelect.appendChild(option);
        }
    }
</script>


<script>
    // Get the current date
    const currentDate = new Date();

// Set the time zone to 'Asia/Manila'
const options = { timeZone: 'Asia/Manila', year: 'numeric', month: '2-digit', day: '2-digit' };
const formattedDate = currentDate.toLocaleString('en-US', options);

// Extract the year, month, and day from the formatted date
const parts = formattedDate.split('/');
const year = parts[2];
const month = parts[0].padStart(2, '0');
const day = parts[1].padStart(2, '0');

// Create the desired format 'YYYY-MM-DD'
const desiredFormat = `${year}-${month}-${day}`;

// Set the value of the input element to the desired format
document.getElementById('date_now').value = desiredFormat;


</script>


<script>
    function showTooltip() {
        const tooltip = document.getElementById('tooltip');
        tooltip.classList.toggle('hidden');
    }

	function showTooltip1() {
        const tooltip = document.getElementById('tooltip1');
        tooltip.classList.toggle('hidden');
    }

	function showTooltip2() {
        const tooltip = document.getElementById('tooltip2');
        tooltip.classList.toggle('hidden');
    }

	function showTooltip3() {
        const tooltip = document.getElementById('tooltip3');
        tooltip.classList.toggle('hidden');
    }

    function updateTooltip() {
        const roomCategory = document.getElementById('room_category').value;
        const tooltip = document.getElementById('tooltip');
		

        if (roomCategory === "Standard" || roomCategory === "deluxe") {
            // Show the message for "Standard" and "Deluxe" category
            tooltip.textContent = "This Room is Good for 2 people. Additional extra person(Adults) will have a charge of ₱950/head";
        } else if (roomCategory === "Premium") {
            // Show the message for "Premium" category
            tooltip.textContent = "This Room is Good for 3 people. Additional extra person(Adults) will have a charge of ₱950/head";
        } else if (roomCategory === "Deluxe") {
            // Show the message for "Premium" category
            tooltip.textContent = "This Room is Good for 2 people. Additional extra person(Adults) will have a charge of ₱950/head";
        }else {
            // Default message if the selected category is not handled above
            tooltip.textContent = "Unknown category message.";
        }

    }

    // Call this function initially to set the tooltip message based on the initial value of room_category
    updateTooltip();
	
</script>

<script>
   

   function showSelectedImage() {
    const imageSelect = document.getElementById('imageSelect');
    const selectedValue = imageSelect.value;
    const images = document.querySelectorAll('.proof');

    // Hide all images
    images.forEach(image => {
        image.style.display = 'none';
    });

    // Display the selected image
    const selectedImage = document.querySelector(`.proof[src="images/payment/${selectedValue}.png"]`);
    if (selectedImage) {
        selectedImage.style.display = 'block';
    }
}

</script>


<script>
    const pricePerNight = <?= $fetch_products['price'] ?>; // Replace with the actual base price per night fetched from backend
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const adultsSelect = document.getElementById('adultsSelect');
	const bed = document.getElementById('bed');
	const pillow = document.getElementById('pillow');
    const numberOfRoomsInput = document.getElementById('number_of_rooms');
    const numberOfRoomsText = document.getElementById('number_of_rooms_text');
    const numberOfNightsInput = document.getElementById('number_of_nights');
    const numberOfNightsText = document.getElementById('number_of_nights_text');
    const additionalAmountText = document.getElementById('additional_amount_text');
    const additionalPersonText = document.getElementById('additional_person_text'); 
	const additionalBedText = document.getElementById('additional_bed_text'); // New <p> tag for additional bed
	const additionalPillowText = document.getElementById('additional_pillow_text'); // New <p> tag for additional pillow
    const totalPriceInput = document.getElementById('total_price_input');
    const totalPriceText = document.getElementById('total_price_text');



	function calculateAdditionalCharge(category, numberOfAdults) {
    let additionalCharge = 0;
    let additionalPersons = 0;

		if (category === 'Standard' || category === 'Deluxe') {
			if (numberOfAdults === 3) {
				additionalCharge = 950;
				additionalPersons = 1;
			} else if (numberOfAdults === 4) {
				additionalCharge = 950 * 2;
				additionalPersons = 2;
			} else if (numberOfAdults === 5) {
				additionalCharge = 950 * 3;
				additionalPersons = 3;
			}
		} else if (category === 'Premium') {
			if (numberOfAdults >= 4) {
				additionalCharge = 950 * (numberOfAdults - 3);
				additionalPersons = numberOfAdults - 3;
			}
		}

		additionalPersonText.textContent = `Additional Person: ${additionalPersons}`;
		return additionalCharge;
	}

	function updateAdditionalCharge() {
		const category = document.getElementById('room_category').value; // Get the value of the category input
        const numberOfAdults = parseInt(adultsSelect.value);
        const additionalCharge = calculateAdditionalCharge(category, numberOfAdults);
        return additionalCharge;
    }

//bed
	function calculateAdditionalBedCharge(numberOfBeds) {
    let additionalChargeBed = 0;
    let additionalBed = 0;

    if (numberOfBeds === 1) {
        additionalChargeBed = 500;
        additionalBed = 1;
    } else if (numberOfBeds === 2) {
        additionalChargeBed = 500 * 2;
        additionalBed = 2;
    } 

    additionalBedText.textContent = `Additional Bed: ${additionalBed}`;
    return additionalChargeBed;
	}

	function updateAdditionalBedCharge() {
        const numberOfBeds = parseInt(bed.value);
        const additionalChargeBed = calculateAdditionalBedCharge(numberOfBeds);
        return additionalChargeBed;
    }

//pillows
	function calculateAdditionalPillowCharge(numberOfPillows) {
    let additionalChargePillow = 0;
    let additionalPillow = 0;

    if (numberOfPillows === 1) {
        additionalChargePillow = 0;
        additionalPillow = 1;
    }else if (numberOfPillows === 2) {
        additionalChargePillow = 0;
        additionalPillow = 2;
    }else if (numberOfPillows === 3) {
        additionalChargePillow = 100;
        additionalPillow = 3;
    } 

    additionalPillowText.textContent = `Additional Pillow: ${additionalPillow}`;
    return additionalChargePillow;
	}

	function updateAdditionalPillowCharge() {
        const numberOfPillows = parseInt(pillow.value);
        const additionalChargePillow = calculateAdditionalPillowCharge(numberOfPillows);
        return additionalChargePillow;
    }
    // Function to update the additional charge based on the selected number of adults


    // Function to calculate the number of nights and update the total price and text
    function calculateTotalPrice() {
    const checkInDate = new Date(checkInInput.value);
    const checkOutDate = new Date(checkOutInput.value);
    const timeDiff = checkOutDate - checkInDate;
    const numberOfNights = timeDiff > 0 ? Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) : 0;
    const numberOfRooms = parseInt(numberOfRoomsInput.value);
    const additionalCharge = updateAdditionalCharge();
	const additionalChargeBed = updateAdditionalBedCharge();
	const additionalChargePillow = updateAdditionalPillowCharge();
    const totalPrice = pricePerNight * numberOfNights * numberOfRooms + additionalCharge + additionalChargeBed + additionalChargePillow;
	const formattedPrice = totalPrice.toLocaleString(undefined, { style: 'currency', currency: 'PHP', minimumFractionDigits: 2 });


	numberOfNightsInput.value = numberOfNights;
	totalPriceInput.value = `${totalPrice}`; // Display the total price with the peso sign and two decimal places in the input
   

	totalPriceText.textContent = `TOTAL PRICE: ${formattedPrice}`;

	numberOfNightsText.textContent = `Number of Nights: ${numberOfNights}`;
	numberOfRoomsText.textContent = `Total Rooms: ${numberOfRooms}`;
	additionalAmountText.textContent = `Additional Person: ${additionalCharge}`;
	additionalBedText.textContent = `Additional Beds: ${additionalChargeBed}`;
	additionalPillowText.textContent = `Additional Pillow: ${additionalChargePillow}`;


}

    // Function to disable past dates in the 'check_in' input
    function disablePastDates() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const minDate = `${year}-${month}-${day}`;

        checkInInput.min = minDate;
    }

    // Call the disablePastDates function initially to disable past dates
    disablePastDates();

    // Add event listeners to the date inputs and number of rooms input to trigger the calculation
    checkInInput.addEventListener('change', function () {
        const selectedDate = new Date(checkInInput.value);
        selectedDate.setDate(selectedDate.getDate() + 1); // Set minimum date for check_out to the day after check_in

        // Format the minimum date to yyyy-mm-dd
        const year = selectedDate.getFullYear();
        const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
        const day = String(selectedDate.getDate()).padStart(2, '0');
        const minDate = `${year}-${month}-${day}`;

        // Set the minimum date for check_out input
        checkOutInput.min = minDate;
        checkOutInput.value = minDate; // Also update the value to the minimum date if it was previously less than the new minimum.

        calculateTotalPrice();
    });

    checkInInput.addEventListener('input', function () {
        const today = new Date().toISOString().split('T')[0]; // Get current date in the format 'yyyy-mm-dd'
        if (checkInInput.value < today) {
            checkInInput.value = today; // If the selected date is earlier than today, set it to today's date
        }

        calculateTotalPrice();
    });

	checkInInput.addEventListener('change', calculateTotalPrice);
    checkOutInput.addEventListener('change', calculateTotalPrice);
    numberOfRoomsInput.addEventListener('input', calculateTotalPrice);
	adultsSelect.addEventListener('change', calculateTotalPrice);
	bed.addEventListener('change', calculateTotalPrice);
	pillow.addEventListener('change', calculateTotalPrice);


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




<!-- //Calendar -->
<!-- gallery popup -->
<link rel="stylesheet" href="css/swipebox.css">
				<script src="js/jquery.swipebox.min.js"></script> 
					<script type="text/javascript">
						jQuery(function($) {
							$(".swipebox").swipebox();
						});
					</script>
<!-- //gallery popup -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
<!-- flexSlider -->
				<script defer src="js/jquery.flexslider.js"></script>
				<script type="text/javascript">
				$(window).load(function(){
				  $('.flexslider').flexslider({
					animation: "slide",
					start: function(slider){
					  $('body').removeClass('loading');
					}
				  });
				});
			  </script>
			<!-- //flexSlider -->
<script src="js/responsiveslides.min.js"></script>
			<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						  // Slideshow 4
						  $("#slider4").responsiveSlides({
							auto: true,
							pager:true,
							nav:false,
							speed: 500,
							namespace: "callbacks",
							before: function () {
							  $('.events').append("<li>before event fired.</li>");
							},
							after: function () {
							  $('.events').append("<li>after event fired.</li>");
							}
						  });
					
						});
			</script>
		<!--search-bar-->
		<script src="js/main.js"></script>	
<!--//search-bar-->
<!--tabs-->
<script src="js/easy-responsive-tabs.js"></script>
<script>
$(document).ready(function () {
$('#horizontalTab').easyResponsiveTabs({
type: 'default', //Types: default, vertical, accordion           
width: 'auto', //auto or any width like 600px
fit: true,   // 100% fit in a container
closed: 'accordion', // Start closed if in accordion view
activate: function(event) { // Callback function if tab is switched
var $tab = $(this);
var $info = $('#tabInfo');
var $name = $('span', $info);
$name.text($tab.text());
$info.show();
}
});
$('#verticalTab').easyResponsiveTabs({
type: 'vertical',
width: 'auto',
fit: true
});
});
</script>
<!--//tabs-->
<!-- smooth scrolling -->
	<script type="text/javascript">
		$(document).ready(function() {
		
			var defaults = {
			containerID: 'toTop', // fading element id
			containerHoverID: 'toTopHover', // fading element hover id
			scrollSpeed: 1200,
			easingType: 'linear' 
			};
										
		$().UItoTop({ easingType: 'easeOutQuart' });
		});

	
	</script>



	
	<div class="arr-w3ls">
	<a href="#home" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	</div>
<!-- //smooth scrolling -->
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<?php include 'includes/alers.php'; ?>

</body>
		<!-- HTML code -->

</html>


