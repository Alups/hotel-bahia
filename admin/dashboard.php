<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
}


// Get the current date
// Get the current date
$today = new DateTime();


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
   <link href="../library/daterangepicker.css" rel="stylesheet" />

   <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
   <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
   
   <link rel="icon" type="images/x-icon" href="../images/home-img-1.png" />
   <link rel="stylesheet" href="../css/admin_style.css">



</head>
<body className='snippet-body'>
<body id="body-pd">


<?php include '../components/admin_header.php'; ?>

<section class="dashboard">






<div class="header1">
<h1 id="currentDate"><?php echo date('F j, Y'); ?></h1>
    <form action="reserve.php" method="GET">
      <button type="submit">Create New Reservation</button>
    </form>
  </div>

  
    
       
    
<br>
<div class="box-container">

   <div class="box">
      <div class="row">
         <div class="col">
         <?php

            // Get today's date in 'Y-m-d' format
            $todayDate = date('Y-m-d');

            $select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE DATE(check_in) = :todayDate");
            $select_bookings->bindParam(':todayDate', $todayDate);
            $select_bookings->execute();
            $number_of_bookings = $select_bookings->rowCount();
            ?>

         <h3 style="color: green; text-align: center;"><?= $number_of_bookings; ?></h3>
         <p>Arrivals Today</p>
         </div>

         <div class="col">
         <?php
         // Get today's date in 'Y-m-d' format
         $todayDate = date('Y-m-d');

         $select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE check_out = :todayDate");
         $select_bookings->bindParam(':todayDate', $todayDate);
         $select_bookings->execute();
         $number_of_bookings = $select_bookings->rowCount();
         ?>
           <h3 style="color: red; text-align: center;"><?= $number_of_bookings; ?></h3>
         <p>Departure Today</p>
         </div>

         <div class="col">
         <?php
         // Get today's date in 'Y-m-d' format
         $todayDate = date('Y-m-d');

         $select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE date_now = :todayDate");
         $select_bookings->bindParam(':todayDate', $todayDate);
         $select_bookings->execute();
         $number_of_bookings = $select_bookings->rowCount();
         ?>

         <h3 style="text-align: center;"><?= $number_of_bookings; ?></h3>
         <p>Booked Today</p>


         </div>
         <!-- <div class="col">
               <?php
                  $total_pendings = 0;
                  $select_pendings = $conn->prepare("SELECT payment_status FROM `bookings` WHERE payment_status = ?");
                  $select_pendings->execute(['Pending']);
                  if($select_pendings->rowCount() > 0){
                     while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                        $total_pendings += $fetch_pendings['price'];
                     }
                  }
               ?>
               <h3>&#8369<?= number_format($total_pendings, 0, '.', ',')?>.00</h3>
               <p>Total pendings</p>
               
         </div> -->
         <div class="col">
                     <?php
            $total_price_today = 0;
            $today = date("Y-m-d"); // Get today's date in the format 'YYYY-MM-DD'

            $select_bookings_today = $conn->prepare("SELECT price FROM `bookings` WHERE date_now = ?");
            $select_bookings_today->execute([$today]);

            if ($select_bookings_today->rowCount() > 0) {
               while ($fetch_booking = $select_bookings_today->fetch(PDO::FETCH_ASSOC)) {
                  $total_price_today += $fetch_booking['price'];
               }
            }
            ?>

               <h3>&#8369 <?= number_format($total_price_today, 0, '.', ',') ?>.00</h3>
               <p>Revenue Today</p>
         </div>
      </div>
      <div class="row">
         <!-- <a href="bookings.php" class="btn">See booking</a> -->
      </div>
   </div>

   



<!-- Add the 'box' container for the room information -->
<div class="box">
  <div class="row">
  <select id="roomCategoryFilter" onchange="filterRoomsByCategory()">
  <option value="Standard">Standard</option>
  <option value="Deluxe">Deluxe</option>
  <option value="Premium">Premium</option>
   </select>
    <div class="col" id="standardColumn">
    <?php
            // Assuming you have already set the timezone to 'Asia/Manila' using date_default_timezone_set()

            $select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE category = 'Standard' AND status = 'available'");
            $select_rooms->execute();
            $rooms = $select_rooms->fetchAll(PDO::FETCH_ASSOC);
            $number_of_rooms = $select_rooms->rowCount();
            ?>     
             <h3 style="text-align: center;"><?= $number_of_rooms; ?></h3>
      <p>Available Rooms for Standard</p>
    </div>   
    <div class="col" id="deluxeColumn" style="display: none;">
    <?php
            // Assuming you have already set the timezone to 'Asia/Manila' using date_default_timezone_set()

            $select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE category = 'Deluxe' AND status = 'available'");
            $select_rooms->execute();
            $rooms = $select_rooms->fetchAll(PDO::FETCH_ASSOC);
            $number_of_rooms = $select_rooms->rowCount();
            ?>      
            <h3 style="text-align: center;"><?= $number_of_rooms; ?></h3>
      <p>Available Rooms for Deluxe</p>
    </div>   
    <div class="col" id="premiumColumn" style="display: none;">
    <?php
            // Assuming you have already set the timezone to 'Asia/Manila' using date_default_timezone_set()

            $select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE category = 'Premium' AND status = 'available'");
            $select_rooms->execute();
            $rooms = $select_rooms->fetchAll(PDO::FETCH_ASSOC);
            $number_of_rooms = $select_rooms->rowCount();
            ?>    
              <h3 style="text-align: center;"><?= $number_of_rooms; ?></h3>
      <p>Available Rooms for Premium</p>
    </div>    
  </div>
</div>

   <!-- <div class="box">
      <div class="row">
      <?php
         if($fetch_profile['role'] == "admin"){
            $select_admins = $conn->prepare("SELECT * FROM `admins`");
            $select_admins->execute();
            $number_of_admins = $select_admins->rowCount();

            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount();

            echo '<div class="col">
            <h3>'.$number_of_users.'</h3>
            <p>User accounts</p>
            <a href="users_accounts.php" class="btn">see users</a>
            </div>';

            echo '<div class="col">';
            echo '<h3>'.$number_of_admins.'</h3>';
            echo '<p>Admin users</p>';
            echo '<a href="admin_accounts.php" class="btn">see admins</a>';
            echo '</div>';
         }
      ?>
         <div class="col">
            <?php
               $select_messages = $conn->prepare("SELECT * FROM `messages`");
               $select_messages->execute();
               $number_of_messages = $select_messages->rowCount()
            ?>
            <h3><?= $number_of_messages; ?></h3>
            <p>Feedbacks</p>
            <a href="messages.php" class="btn">see feedbacks</a>
         </div>
         <div class="col">
            <?php 
               $select_logs = $conn->prepare("SELECT * FROM `logs`");
               $select_logs->execute();
               $number_of_logs = $select_logs->rowCount()
            ?>
            <h3><?= $number_of_logs; ?></h3>
            <p>Logs</p>
            <a href="logs.php" class="btn">see logs</a>
         </div>
      </div>
   </div> -->

      <div class="box">
      <h2>Reservations</h2>

            <nav>
            <ul>
               <li><a href="#" onclick="showArrivals()" id="arrivalsLink"  class="active">Arrivals</a></li>
               <li><a href="#" onclick="showDepartures()" id="departuresLink">Departures</a></li>
            </ul>
            </nav>

            <table id="arrivalsTable">
               <!-- Table headers -->
               <thead>
                  <tr>
                     <th>Guest Name</th>
                     <th>Booking ID</th>
                     <th>Number of Rooms</th>
                     <th>Status</th>

                  </tr>
               </thead>
               <tbody>
                  <?php
                  // Replace 'your_db_connection' with the actual code to connect to your database
                  // Fetch today's arrivals from the database
                  // Assuming the check_in_date is stored as a DATE field in the database
                  $today = date("Y-m-d"); // Get today's date in the format 'YYYY-MM-DD'

                  // Replace 'your_db_connection' with the actual code to connect to your database
                  $select_arrivals = $conn->prepare("SELECT name, payment_status, booking_id, rooms FROM bookings WHERE DATE(check_in) = :today");
                  $select_arrivals->bindParam(':today', $today);
                  $select_arrivals->execute();
                  $today_arrivals = $select_arrivals->fetchAll(PDO::FETCH_ASSOC);

                  // Loop through the fetched data and display it in the table
                  foreach ($today_arrivals as $arrival) {
                     echo "<tr>";
                     echo "<td>" . $arrival['name'] . "</td>";
                     echo "<td>" . $arrival['booking_id'] . "</td>";
                     echo "<td style='text-align: center;'>" . $arrival['rooms'] . "</td>";
                     echo "<td>" . $arrival['payment_status'] . "</td>";
                     echo "</tr>";
                  }
                  ?>
               </tbody>
               </table>


         <table id="departuresTable" style="display: none;">

            <!-- Table headers -->
            <thead>
               <tr>
               <th>Guest Name</th>
               <th>Booking ID</th>
               <th>Number of rooms</th>
               </tr>
            </thead>
            <tbody>
               <?php
               // Replace 'your_db_connection' with the actual code to connect to your database
               // Fetch today's arrivals from the database
               // Assuming the check_in_date is stored as a DATE field in the database
               $today = date("Y-m-d"); // Get today's date in the format 'YYYY-MM-DD'
               // Replace 'your_db_connection' with the actual code to connect to your database
   
               $select_arrivals = $conn->prepare("SELECT name, booking_id, rooms FROM bookings WHERE DATE(check_out) = :today");
               $select_arrivals->bindParam(':today', $today);
               $select_arrivals->execute();
               $today_arrivals = $select_arrivals->fetchAll(PDO::FETCH_ASSOC);

               // Loop through the fetched data and display it in the table
               foreach ($today_arrivals as $arrival) {
               echo "<tr>";
               echo "<td>" . $arrival['name'] . "</td>";
               echo "<td>" . $arrival['booking_id'] . "</td>";
               echo "<td style='text-align: center;'>" . $arrival['rooms'] . "</td>";
               echo "</tr>";
               }
               ?>
            </tbody>
         </table>
         </div>
         

         <div class="box">
            <h2>Today's activity</h2>
            <nav>
            <ul>
               <li><a href="#" onclick="showBook()"  id="bookLink" class="active">Booked Today</a></li>
               <li><a href="#" onclick="showCancel()" id="cencelLink">Cancelled</a></li>
            </ul>
            </nav>

            
               
         <table id="bookTable">

            <!-- Table headers -->
            <thead>
               <tr>
               <th>Guest Name</th>
               <th>Booking ID</th>
               <th>Revenue</th>
               <th>Check-in</th>
               </tr>
            </thead>
            <tbody>
               <?php
            
               $today = date("Y-m-d"); // Get today's date in the format 'YYYY-MM-DD'
               // Replace 'your_db_connection' with the actual code to connect to your database
   
               $select_arrivals = $conn->prepare("SELECT name, booking_id, price, check_in FROM bookings WHERE DATE(date_now) = :today");
               $select_arrivals->bindParam(':today', $today);
               $select_arrivals->execute();
               $today_arrivals = $select_arrivals->fetchAll(PDO::FETCH_ASSOC);

               // Loop through the fetched data and display it in the table
               foreach ($today_arrivals as $arrival) {
               echo "<tr>";
               echo "<td>" . $arrival['name'] . "</td>";
               echo "<td>" . $arrival['booking_id'] . "</td>";
               echo "<td>₱" . number_format($arrival['price'], 0, '.', ',') . ".00</td>";
               echo "<td>" . $arrival['check_in'] . "</td>";
               echo "</tr>";
               }
               ?>
            </tbody>
         </table>

         <table id="cancelTable" style="display: none;">

            <!-- Table headers -->
            <thead>
               <tr>
               <th>Guest Name</th>
               <th>Booking ID</th>
               <th>Number of rooms</th>
               </tr>
            </thead>
            <tbody>
               <?php
               // Replace 'your_db_connection' with the actual code to connect to your database
               // Fetch today's arrivals from the database
               // Assuming the check_in_date is stored as a DATE field in the database
               $today = date("Y-m-d"); // Get today's date in the format 'YYYY-MM-DD'
               // Replace 'your_db_connection' with the actual code to connect to your database
   
               $select_arrivals = $conn->prepare("SELECT name, booking_id, rooms FROM bookings WHERE DATE(check_out) = :today");
               $select_arrivals->bindParam(':today', $today);
               $select_arrivals->execute();
               $today_arrivals = $select_arrivals->fetchAll(PDO::FETCH_ASSOC);

               // Loop through the fetched data and display it in the table
               foreach ($today_arrivals as $arrival) {
               echo "<tr>";
               echo "<td>" . $arrival['name'] . "</td>";
               echo "<td>" . $arrival['booking_id'] . "</td>";
               echo "<td>" . $arrival['rooms'] . "</td>";
               echo "</tr>";
               }
               ?>
            </tbody>
         </table>
         </div>


</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js"></script>
<script src="../js/admin_script.js"></script>

<script>



$('#daterange_textbox').daterangepicker({
    ranges:{
        'Today' : [moment(), moment().add(1,'days')],
        'Yesterday' : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days' : [moment().subtract(29, 'days'), moment()],
        'This Month' : [moment().startOf('month'), moment().endOf('month')],
        'Last Month' : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    format : 'YYYY-MM-DD'
}, function(start, end){

    $('#order_table').DataTable().destroy();

    fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

});



</script>



<script>
function filterRoomsByCategory() {
  const selectedCategory = document.getElementById('roomCategoryFilter').value;
  const standardColumn = document.getElementById('standardColumn');
  const deluxeColumn = document.getElementById('deluxeColumn');
  const premiumColumn = document.getElementById('premiumColumn');

  if (selectedCategory === 'Standard') {
    standardColumn.style.display = 'block';
    deluxeColumn.style.display = 'none';
    premiumColumn.style.display = 'none';
  } else if (selectedCategory === 'Deluxe') {
    standardColumn.style.display = 'none';
    deluxeColumn.style.display = 'block';
    premiumColumn.style.display = 'none';
  } else if (selectedCategory === 'Premium') {
    standardColumn.style.display = 'none';
    deluxeColumn.style.display = 'none';
    premiumColumn.style.display = 'block';
  }
}

// Call the filter function initially to show the default selected category (Standard)
filterRoomsByCategory();
</script>

<script>
    function formatDate(date) {
      const options = { month: 'long', day: 'numeric', year: 'numeric' };
      return date.toLocaleDateString(undefined, options);
    }

    function updateDate() {
      const currentDateElement = document.getElementById('currentDate');
      const currentDate = new Date();
      currentDateElement.textContent = formatDate(currentDate);
    }

    // Call updateDate function to update the date immediately
    updateDate();

    // Update the date every 1 second (1000 milliseconds)
    setInterval(updateDate, 1000);
  </script>

<script>
  function showArrivals() {
    document.getElementById('arrivalsTable').style.display = 'table';
    document.getElementById('departuresTable').style.display = 'none';

    // Add the 'active' class to the 'Arrivals' link and remove it from the 'Departures' link
    document.getElementById('arrivalsLink').classList.add('active');
    document.getElementById('departuresLink').classList.remove('active');
  }

  function showDepartures() {
    document.getElementById('arrivalsTable').style.display = 'none';
    document.getElementById('departuresTable').style.display = 'table';

    // Add the 'active' class to the 'Departures' link and remove it from the 'Arrivals' link
    document.getElementById('departuresLink').classList.add('active');
    document.getElementById('arrivalsLink').classList.remove('active');
  }

//HATI TO HAHA
  
   function showBook() {
    document.getElementById('bookTable').style.display = 'table';
    document.getElementById('cancelTable').style.display = 'none';

    // Add the 'active' class to the 'Arrivals' link and remove it from the 'Departures' link
    document.getElementById('bookLink').classList.add('active');
    document.getElementById('cancelLink').classList.remove('active');
  }

  function showCancel() {
    document.getElementById('bookTable').style.display = 'none';
    document.getElementById('cancelTable').style.display = 'table';

    // Add the 'active' class to the 'Departures' link and remove it from the 'Arrivals' link
    document.getElementById('cancelLink').classList.add('active');
    document.getElementById('bookLink').classList.remove('active');
  }
</script>



</body>
</html>

