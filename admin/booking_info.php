<?php

include '../includes/db.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
}

$select_admin = $conn->prepare("SELECT name, role FROM `admins` WHERE id = ?");
$select_admin->execute([$admin_id]);

if ($select_admin->rowCount() > 0) {
    while ($fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC)) {
        $uname = $fetch_admin['name'];
        $role = $fetch_admin['role']; // Fetching the 'role' column
    }
    // You can use the $uname and $role variables as needed here
} else {
    // Handle the case when no records are found for the given admin_id
}




if(isset($_POST['update_payment'])){
   $book_id = $_POST['book_id'];
   $booking_id = $_POST['booking_id'];
   $payment_status = $_POST['payment_status'];
   $room_number = $_POST['room_number'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `bookings` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $book_id]);

   // If the payment_status is 'paid', update the room status to 'available' in the room table
   if ($payment_status === 'Cancelled') {
      $update_room_status = $conn->prepare("UPDATE `rooms` SET status = 'Available' WHERE name = ?");
      $update_room_status->execute([$room_number]);
  }

  $insert_booking_list = $conn->prepare("INSERT INTO `booking_list` (booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, category, payment_status, method, proof, price, checkout) SELECT booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, category, payment_status, method, proof, price, 1 FROM `bookings` WHERE id = ?");
  $insert_booking_list->execute([$book_id]);

  if ($payment_status === 'Cancelled') {
   $delete_booking = $conn->prepare("DELETE FROM `bookings` WHERE id = ?");
   $delete_booking->execute([$book_id]);
}
 

   $event = 'Update booking Status';
   $log = 'Updated booking no.'.$booking_id.' to '.$payment_status;

   $logDat = $conn->prepare("INSERT INTO `logs`(username, role, event, log) VALUES(?,?,?,?)");
   $logDat->execute([$uname, $role, $event, $log]);

   // $success_msg[] = 'Booking status has been updated!';
}

if(isset($_POST['update_stat'])){
   $book_id = $_POST['book_id'];
   $booking_id = $_POST['booking_id'];
   $stat = $_POST['status'];
   $room_number = $_POST['room_number'];
   $stat = filter_var($stat, FILTER_SANITIZE_STRING);
   $update_stat = $conn->prepare("UPDATE `bookings` SET status = ? WHERE id = ?");
   $update_stat->execute([$stat, $book_id]);

   // If the payment_status is 'paid', update the room status to 'available' in the room table
 
 

   $event = 'Update booking Status';
   $log = 'Updated booking id.'.$booking_id.' to '.$stat;

   $logDat = $conn->prepare("INSERT INTO `logs`(username, role, event, log) VALUES(?,?,?,?)");
   $logDat->execute([$uname, $role, $event, $log]);

   // $success_msg[] = 'Booking status has been updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $booking_id = $_GET['booking_id'];
   
   // Get the room number associated with the booking
   $get_room_number = $conn->prepare("SELECT rooms FROM `bookings` WHERE id = ?");
   $get_room_number->execute([$delete_id]);
   $room_number = $get_room_number->fetchColumn();

   $update_payment_status = $conn->prepare("UPDATE `bookings` SET payment_status = 'Paid' WHERE id = ?");
   $update_payment_status->execute([$delete_id]);
   
   // Delete the booking from the bookings table

   $insert_booking_list = $conn->prepare("INSERT INTO `booking_list` (booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, category,payment_status,method,proof, price,  checkout) SELECT booking_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, category,payment_status,method,proof, price, 1 FROM `bookings` WHERE id = ?");
   $insert_booking_list->execute([$delete_id]);

   
   // $delete_booking = $conn->prepare("UPDATE `booking_list` SET checkout = 1  WHERE id = ?");
   // $delete_booking->execute([$delete_id]);
   
   $delete_book = $conn->prepare("DELETE FROM `bookings` WHERE id = ?");
   $delete_book->execute([$delete_id]);
   
   // Update the status of the corresponding room in the rooms table
   $update_room_status = $conn->prepare("UPDATE `rooms` SET `status` = 'Available' WHERE name = ?");
   $update_room_status->execute([$room_number]);
   
    

   $event = 'Removed bookings';
   $log = 'Removed booking no.'.$booking_id;

   $logDat = $conn->prepare("INSERT INTO `logs`(username, role, event, log) VALUES(?,?,?,?)");
   $logDat->execute([$uname, $role, $event, $log]);

   $success_orderdel[] = 'Guest Checked Out';
   // include 'components/booking_cancel.php';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bookings/informations</title>
   <link rel="icon" type="images/x-icon" href="../images/home-img-1.png" />

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

   <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
   <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
   <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body className='snippet-body'>
<body id="body-pd">

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<!-- <section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_box" placeholder="search here..." maxlength="100" class="box">
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>
</section> -->

<h1 class="heading">Booking informations</h1>


        
               <div class="box-container">
         <?php	
         $select_product = $conn->prepare("SELECT * FROM `bookings` WHERE status = 'approved'");
         $select_product->execute();
         $result = $select_product->fetchAll();
      ?>

<?php
// Assuming you have a database connection established in $conn

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Step 1: Retrieve the bookings for the specified user
    $select_user_bookings = $conn->prepare("
        SELECT *
        FROM `bookings`
        WHERE user_id = :user_id
    ");
    $select_user_bookings->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $select_user_bookings->execute();
    $result = $select_user_bookings->fetchAll(PDO::FETCH_ASSOC);

    // Step 2: Display the user's booking information in the table
    // ... (code to display the booking info in the table, similar to the original table)
} else {
    // Handle the case when user_id is not provided or invalid
    echo "Invalid user ID.";
}
?>
      
      <form name='frmSearch' action='' method='post' enctype="multipart/form-data">
      <table id="prodtableid" class='table table-striped align-middle caption-top dt-print-table'>
      <thead class="thd">
         <tr>
         <th scope="col" class='table-header' width="16%">Booking Id</th>
         <!-- <th scope="col" class='table-header' width="10%">Total Price</th> -->
         <th scope="col" class='table-header' width="16%">Name</th>
         <th scope="col" class='table-header' width="16%">Category</th>
         <!-- <th scope="col" class='table-header' width="16%">Adult</th>
         <th scope="col" class='table-header' width="16%">Children</th> -->
         <th scope="col" class='table-header' width="40%">Rooms</th>
         <th scope="col" class='table-header' width="16%">Payment Method</th>
         <th scope="col" class='table-header' width="16%">Price</th>
         <th scope="col" class='table-header' width="16%">Check in</th>
         <th scope="col" class='table-header' width="16%">Check out</th>
         <th scope="col" class='table-header' width="16%">Payment Status</th>
         <th scope="col" class='table-header' width="16%">Action</th>
         </tr>
      </thead>
      <tbody id='table-body'>
         <?php
         if(!empty($result)) { 
            foreach($result as $row) {
               $dt = $row['check_in'];
         ?>
         <tr>
            <td><?php echo $row['booking_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <!-- <td><?php echo $row['adults']; ?></td>
            <td><?php echo $row['childs']; ?></td> -->
            <!-- <td><span>&#8369</span><?php echo $row['rooms']; ?></td>-->
           
            <td style="padding-left: 25px;"><?php echo $row['rooms']; ?></td>
            <td>
            <?php if ($row['method'] == 'Gcash' || $row['method'] == 'AliPay' || $row['method'] == 'UnionPay'): ?>
               <a href="#viewpayment_<?php echo $row['id']; ?>" data-bs-toggle="modal"><?php echo $row['method']; ?></a>
            <?php else: ?>
               <?php echo $row['method']; ?>
            <?php endif; ?>
         </td>
            <td>₱<?= number_format($row['price'], 0, '.', ',') ?>.00</td>
            <td><?php echo $row['check_in']; ?></td>
            <td><?php echo $row['check_out']; ?></td>
            <?php if($row['payment_status'] == "Paid"){ ?>
               <td style="color: green;"><a href="#editstat1_<?php echo $row['booking_id']; ?>" class="aa" data-bs-toggle="modal"><?php echo $row['payment_status']; ?></a></td>
               <?php }else{ ?>
                  <td style="color: red;"><a href="#editstat1_<?php echo $row['booking_id']; ?>" class="a" data-bs-toggle="modal"><?php echo $row['payment_status']; ?></a></td>
            <?php } ?>
            <td>
            <!-- <a href="#editstat1_<?php echo $row['booking_id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-edit"></i></a> -->
            <a href="#viewstat_<?php echo $row['booking_id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-eye"></i></a>
            <button type="button" class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?php  echo $row['id'].'&booking_id='.$row['booking_id'];?>"><i class="fas fa-sign-out" aria-hidden="true"></i></button>
            </td>
            <?php include 'modal_edit.php'; ?>
         </tr>
         <?php
            }
         }
         ?>
      </tbody>
      </table>
      <input type="text" class="printTitle" maxlength="100" placeholder="Enter header title" id="tangna">
      </form>

      <div class="modal expand" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
               <img src="../images/warning.png" class="img-fluid rounded mx-auto d-block" alt="">
               <div class="modal-body text-center border-0">
                  <h1>This guest will check out?</h1>
               </div>
            <div class="modal-footer justify-content-center text-center border-0">
               <button  class="btnm btn-delete-cancel" data-bs-dismiss="modal">Cancel</button>
               <a id="link" class="btnm btn-delete-yes">Yes</a>
            </div>
         </div>
      </div>
   </div>
</div>     

</section>












<script src="../js/admin_script.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudfire.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="../js/buttons.print.js"></script>

<script>
   $(document).ready(function () {
    $('#prodtableid').DataTable({
      order: [[1, "desc"]],
      dom: 'Bfrtip',
      buttons: [{
         extend: 'print',
         exportOptions: {
            columns: [ 0, 1, 2, 3 , 4, 5, 6 ]
         },
         repeatingHead: {
            logo: '../images/logo.png',
            logoPosition: 'center',
            logoStyle: 'margin-right: 100%',
            title: ''
         },
         footer: 'he'
      }]
    });

   //  var count=0;
   //    $('#prodtableid tr').each(function(){
   //       count++;
   //    });

   });


   var exampleModal = document.getElementById('deleteModal')
   exampleModal.addEventListener('show.bs.modal', function (event) {
   // Button that triggered the modal
   var button = event.relatedTarget
   // Extract info from data-bs-* attributes
   var idkoto = button.getAttribute('data-bs-whatever')
   // If necessary, you could initiate an AJAX request here
   document.getElementById("link").setAttribute("href","bookings.php?delete=" + idkoto);
   })
   
   if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>

<?php include '../components/alers.php'; ?>
   
</body>
</html>