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
   $name = $_GET['name'];
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);

   $event = 'Remove Admin Account';
   $log = 'Removed admin account '.$name;

   $logDat->execute([$uname, $role, $event, $log]);


   $success_admindel[]= "Removed";
}

if(isset($_POST['update_admin'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $id = $_POST['id'];
   $id = filter_var($id, FILTER_SANITIZE_STRING);
   

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $role = $_POST['role'];
   $role = filter_var($role, FILTER_SANITIZE_STRING);
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $warning_msg[] = 'Please enter old password!';
   }elseif($old_pass != $prev_pass){
      $warning_msg[] = 'Old password not matched!';
   }elseif($new_pass != $confirm_pass){
      $warning_msg[] = 'Confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
         $update_profile_name->execute([$name, $id]);
         $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? , role = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $role, $id]);

         $event = 'Upadate Admin Account';
         $log = 'Updated admin account '.$name;
      
         $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
         $logDat->execute([$uname, $event, $log]);

         $success_msg[] = 'Updated Successfully!';
      }else{
         $info_msg[] = 'Please enter a new password!';
      }
   }
   
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $role = $_POST['role'];
   $role = filter_var($role, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admin->execute([$name]);

   if($select_admin->rowCount() > 0){
      $warning_msg[] = 'Username already exist!';
   }else{
      if($pass != $cpass){
         $info_msg[] = 'Confirm password not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password, role) VALUES(?,?,?)");
         $insert_admin->execute([$name, $cpass, $role]);

         $event = 'Add Admin Account';
         $log = 'Added admin account '.$name;
      
         $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
         $logDat->execute([$uname, $event, $log]);

         $success_msg[] = 'New admin successfully added!';
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
   <title>Admin accounts</title>
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

   <h1 class="heading">Admin accounts <button class="btns"><i class="fas fa-plus-square" href="#myModal1" ></i></button></h1>

   <div id="myModal1" class="modal">

   <!-- Modal content -->
   <div class="modal-content">
      <span class="close">&times;</span>
         <section class="add-products">

         <h1 class="heading">add new admin account</h1>

         <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="flex">
               <div class="inputBox">
                  <span>User name <i class="notice">*</i></span>
                  <input type="text" class="box form-control" required maxlength="100" placeholder="Enter username" name="name">
               </div>
               <div class="inputBox">
                  <select hidden name="role" class="box form-control" required>
                     <option value="admin">Admin</option>
                  </select>
                </div>
                <div class="inputBox">
                  <span>Password <i class="notice">*</i></span>
                  <input type="password" class="box form-control" required maxlength="100" placeholder="Enter your password" name="pass">
               </div>
               <div class="inputBox">
                  <span>Confirm <i class="notice">*</i></span>
                  <input type="password" class="box form-control" required maxlength="100" placeholder="Confirm your password" name="cpass">
               </div>
               </div>
            
            <input type="submit" value="Add now" class="btn" name="submit">
         </form>

      </section>
   </div>
   </div>

   <div class="box-container">
         <?php	
         $select_admins = $conn->prepare("SELECT * FROM `admins`");
         $select_admins->execute();
         $result = $select_admins->fetchAll();
      ?>
      <form name='frmSearch' action='' method='post'>
      <table id="admintableid" class='table table-striped align-middle caption-top'>
      <thead class="thd">
         <tr>
         <th scope="col" class='table-header' width="40%">Username</th>
         <th scope="col" class='table-header' width="40%">User Role</th>
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
            <td><?php echo $row['role']; ?></td>
            <td>
            <a href="#editadmin_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-edit"></i></a>
            <button <?php if($row['role'] == "admin"){ echo 'class="delete-btn"'; }else{ echo 'class="delete-btn"';}?> type="button"  data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?php  echo $row['id'].'&name='.$row['name'];?>"><i class="fas fa-trash-alt"></i></button>   
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
            <h1>Are you sure you want to remove this user?</h1>
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
    $('#admintableid').DataTable();
   });

   (() => {
   'use strict'

   // Fetch all the forms we want to apply custom Bootstrap validation styles to
   const forms = document.querySelectorAll('.needs-validation')

   // Loop over them and prevent submission
   Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
         if (!form.checkValidity()) {
         event.preventDefault()
         event.stopPropagation()
         }

         form.classList.add('was-validated')
      }, false)
   })
   })()

   var exampleModal = document.getElementById('deleteModal')
   exampleModal.addEventListener('show.bs.modal', function (event) {
   // Button that triggered the modal
   var button = event.relatedTarget
   // Extract info from data-bs-* attributes
   var idkoto = button.getAttribute('data-bs-whatever')
   // If necessary, you could initiate an AJAX request here
   document.getElementById("link").setAttribute("href","admin_accounts.php?delete=" + idkoto);
   })

      if ( window.history.replaceState ) {
   window.history.replaceState( null, null, window.location.href );
   }

</script>

<?php include '../components/alers.php'; ?>

</body>
</html>