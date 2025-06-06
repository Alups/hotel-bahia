<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $id = $_POST['id'];
   $id = filter_var($id, FILTER_SANITIZE_STRING);
   

   $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
   $update_profile_name->execute([$name, $id]);

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
      $warning_msg[] = 'please enter old password!';
   }elseif($old_pass != $prev_pass){
      $warning_msg[] = 'old password not matched!';
   }elseif($new_pass != $confirm_pass){
      $warning_msg[] = 'confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? , role = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $role, $id]);
         $success_msg[] = 'password updated successfully!';
      }else{
         $info_msg[] = 'please enter a new password!';
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
   <title>Update profile</title>
   
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

<section class="form-container">
   <?php

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parts = parse_url($url);
        parse_str($parts['query'], $query);
        $user_id = $query['id'];

        $select_user = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
        $select_user->execute([$user_id]);
        if($select_user->rowCount() > 0){
            while($fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC)){
            $role = $fetch_profile['role'];
    ?>
   <form action="" method="post">
      <h3>update profile</h3>
      <input type="hidden" name="role" value="<?= $fetch_profile['role']; ?>">
      <input type="hidden" name="id" value="<?= $fetch_profile['id']; ?>">
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
      <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <?php
         if($role == "admin"){
      ?>
      <select name="role" class="box" required>
         <option selected disabled><?= $fetch_profile['role']; ?></option>
         <option value="staff">Staff</option>
         <option value="admin">Admin</option>
      </select>
      <?php }
      ?>
      <input type="password" name="old_pass" placeholder="enter old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="confirm new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <div class="flex-btn">
         <input type="submit" value="update now" class="btn" name="submit">
         <a href="dashboard.php" class="btn-logout">go back</a>
      </div>
   </form>
   <?php
            }}
   ?>

</section>












<script src="../js/admin_script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include '../components/alers.php'; ?>
   
</body>
</html>