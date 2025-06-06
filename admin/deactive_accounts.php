<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
}

$select_name = $conn->prepare("SELECT name FROM `admins` WHERE id = ?");
$select_name->execute([$admin_id]);
if($select_name->rowCount() >= 0){
   while($fetch_name = $select_name->fetch(PDO::FETCH_ASSOC)){
      $uname = $fetch_name['name'];
}}

if(isset($_GET['delete'])){
   $delete = $_GET['delete'];
   $name = $_GET['name'];

   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete]);

   $event = 'deleted User Account';
   $log = 'deleted user account '.$name;

   $logDat = $conn->prepare("INSERT INTO `logs`(username, role, event, log) VALUES(?,?,?,?)");
   $logDat->execute([$uname, $role, $event, $log]);

   $success_restore[] = "deleted";
}

if(isset($_POST['update_user'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($new_pass != $confirm_pass){
      $warning_msg[] = 'Confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_user_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE email = ?");
         $update_user_pass->execute([$confirm_pass, $email]);

         $event = 'Update User Account';
         $log = 'Updated user account '.$name;

         $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
         $logDat->execute([$uname, $event, $log]);

         $success_msg[] = 'Account has been updated successfully!';
      }else{
         $warning_msg[] = 'Add new password!';
      }
   }
   
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_admin->execute([$email]);

   if($select_admin->rowCount() > 0){
      $warning_msg[] = 'Email already exist!';
   }else{
      if($pass != $cpass){
         $info_msg[] = 'Confirm password not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_admin->execute([$name, $email, $cpass]);

         $event = 'Add New User Account';
         $log = 'Added new user account '.$name;

         $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
         $logDat->execute([$uname, $event, $log]);

         $success_msg[] = 'New user is added successfully!';
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
   <title>Inactive accounts</title>
   <link rel="icon" type="images/x-icon" href="../images/home-img-1.png" />

   <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
   <link rel="icon" type="images/x-icon" href="../images/home-img-1.png" />
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

   <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
   <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
   
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body className='snippet-body'>
<body id="body-pd">

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">inactive user accounts</h1>

   <div class="box-container">
         <?php	
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE deactive = 1");
         $select_user->execute();
         $result = $select_user->fetchAll();
      ?>
      <form name='frmSearch' action='' method='post'>
      <table id="usertableid" class='table table-striped align-middle caption-top'>
      <thead class="thd">
         <tr>
         <th scope="col" class='table-header' width="30%">Name</th>
         <th scope="col" class='table-header' width="30%">Email</th>
         <th scope="col" class='table-header' width="20%">Number</th>
         <th scope="col" class='table-header' width="20%">Action</th>
         </tr>
      </thead>
      <tbody id='table-body'>
         <?php
         if(!empty($result)) { 
            foreach($result as $row) {
         ?>
         <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['number']; ?></td>
            <td>
            <a href="#viewuser_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-eye"></i></a>
            <a href="#edituser_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-edit"></i></a>
            <button type="button" class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?php  echo $row['id'];?>&name=<?php echo $row['name']?>"><i class="fas fa-arrow-rotate-left"></i></button>
            </td>
            <?php include 'modal_edit.php'; ?>
         </tr>
         <?php
            }
         }
         ?>
      </tbody>
      </table>
      </form>
   </div>

   <div class="modal expand" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content">
            <img src="../images/warning.png" class="img-fluid rounded mx-auto d-block" alt="">
            <div class="modal-body text-center border-0">
            <h1>Are you sure you want to restore this user account?</h1>
            </div>
            <div class="modal-footer justify-content-center text-center border-0">
            <button  class="btnm btn-delete-cancel" data-bs-dismiss="modal">Cancel</button>
            <a id="link" class="btnm btn-delete-yes">Yes</a>
            </div>
         </div>
      </div>
      </div>

</section>




<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/admin_script.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudfire.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script>
   $(document).ready(function () {
    $('#usertableid').DataTable();
   });

    $(function() {
        $(".selectUser").change(function() {
            document.getElementById("usersForm").submit();
        });
    });


   var exampleModal = document.getElementById('deleteModal')
   exampleModal.addEventListener('show.bs.modal', function (event) {
   // Button that triggered the modal
   var button = event.relatedTarget
   // Extract info from data-bs-* attributes
   var idkoto = button.getAttribute('data-bs-whatever')
   // If necessary, you could initiate an AJAX request here
   document.getElementById("link").setAttribute("href","deactive_accounts.php?delete=" + idkoto);
   })

   if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>

<?php include '../components/alers.php'; ?>

</body>
</html>