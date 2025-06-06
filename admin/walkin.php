<?php

include '../includes/db.php';
error_reporting(0);
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
};

$select_name = $conn->prepare("SELECT name FROM `admins` WHERE id = ?");
$select_name->execute([$admin_id]);
if($select_name->rowCount() >= 0){
   while($fetch_name = $select_name->fetch(PDO::FETCH_ASSOC)){
      $uname = $fetch_name['name'];
}}

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
    $random_number = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    $user_id = $random_number;
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
 
		  $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE name = ? AND email = ? AND number = ? AND rooms = ? AND check_in = ? AND check_out = ? AND adults = ? AND childs = ? AND category = ? AND price = ? AND date_now = ?");
		  $verify_bookings->execute([ $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs, $room_category, $total_price, $date_now]);
 
		  if($verify_bookings->rowCount() > 0){
			 $warn_msg[] = 'room booked alredy!';
		  }else{
            
			$book_room = $conn->prepare("INSERT INTO `bookings` (user_id, booking_id, name, email, number, rooms, check_in, check_out, adults, childs, category, proof, method, price, date_now) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $book_room->execute([$user_id, $booking_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs, $room_category, $proof, $method, $total_price, $date_now]);
			//  $room_status_update = $conn->prepare("UPDATE `rooms` SET `status` = 'Occupied' WHERE `name` = ?");
			//  $room_status_update->execute([$rooms]);
 
			 // $payment_update= $conn->prepare("UPDATE `bookings` SET `payment_status` = 'Not Paid' WHERE `method` = ?");
			 // $payment_update->execute([$method]);
 
 
			 
			 $success_msg[] = 'Your reservation is on process, please wait for the approval';
 
			//  include 'components/booking_id.php';
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
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Categories</title>

   <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
   <link rel="icon" type="images/x-icon" href="../images/home-img-1.png" />
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
   <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body className='snippet-body'>
<body id="body-pd">

<?php include '../components/admin_header.php'; ?>

<section class="show-products">

   <h1 class="heading">WALKIN BOOKINGS</h1>



   <div class="box-container">
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
            $roomId = $fetch_room['id'];

                ?>
	<form action="" method="post" enctype="multipart/form-data" class="reservation-form">
    <h3>Make a Reservation</h3>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text"  name="name" id="name" maxlength="50" required placeholder="Full name">
    </div>
    <!-- <div class="form-group">
    <label for="name">Last name</label>
    <input type="text"  name="lname" id="name" maxlength="50" required placeholder="Last name">
    </div> -->
	<div class="form-group">
        <!-- <label for="name">Name</label> -->
		<input type="text" hidden name="date_now" id="date_now" maxlength="50" required value="">
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email"  name="email" id="email" maxlength="50" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="number">Contact Number</label>
        <input type="number"  name="number" id="number" maxlength="10" min="0" max="9999999999" placeholder="Mobile number">
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


		<img src="../images/payment/Gcash.png" class="proof" height="300" alt="" style="display: none">
		<img src="../images/payment/AliPay.png" class="proof" height="300" alt="" style="display: none">
		<img src="../images/payment/UnionPay.png" class="proof" height="300" alt="" style="display: none">



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
            echo '<h1 class="empty">No Rooms available</h1>
         <a href="index.php" class="cancel"><input value="Back" name="cancel" class="btn"></a>';
        }
    }
    ?>
   </div>

     

</section>




<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="/library/bootstrap-5/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
<!-- contact form -->
<script src="../js/jqBootstrapValidation.js"></script>

<!-- /contact form -->	
<!-- Calendar -->

<script src="js/jquery-ui.js"></script>
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
    const selectedImage = document.querySelector(`.proof[src="../images/payment/${selectedValue}.png"]`);
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

<script>
   $(document).ready(function () {
    $('#cattableid').DataTable();
   });

   var exampleModal = document.getElementById('deleteModal')
   exampleModal.addEventListener('show.bs.modal', function (event) {
   // Button that triggered the modal
   var button = event.relatedTarget
   // Extract info from data-bs-* attributes
   var idkoto = button.getAttribute('data-bs-whatever')
   // If necessary, you could initiate an AJAX request here
   document.getElementById("link").setAttribute("href","categories.php?delete=" + idkoto);
   })

      if ( window.history.replaceState ) {
   window.history.replaceState( null, null, window.location.href );
   }

</script>
<?php include '../components/alers.php'; ?>

<?php include '../includes/alers.php'; ?>

</body>
</html>
