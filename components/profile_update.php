<?php

if(isset($_POST['submit'])){

   $id = $_POST['id'];
   $id = filter_var($id, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   // $address = $_POST['building'] .', '.$_POST['brgy'].', '.$_POST['city'].', '.$_POST['province'] .', '. $_POST['zip_code'];
   // $address = filter_var($address, FILTER_SANITIZE_STRING);
 
    $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? , address = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $address, $user_id]);

   if(!empty($number)){
      $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
      $select_number->execute([$number]);
      $result = $select_number->fetchAll();
      foreach($result as $row) {
         if($select_number->rowCount() > 0){
            if($row['id'] == $user_id){
               $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
               $update_number->execute([$number, $user_id]);
               $success_msg[] = 'Updated';
            }else{
               $warning_msg[] = 'number already taken!';
            }
         }elseif($select_number == null){
               $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
               $update_number->execute([$number, $user_id]);
               $success_msg[] = 'Updated';
         }

      //  if($select_number->rowCount() > 0){
      //     $warning_msg[] = 'number already taken!';
      //  }else{
      //     $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
      //     $update_number->execute([$number, $user_id]);
      //     $success_msg[] = 'Updated';
      //  }
    }
   }
   $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
   $update_number->execute([$number, $user_id]);
   $success_msg[] = 'Updated';
 }

 if(isset($_POST['update_pic'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $old_image = $_POST['old_pro_img'];
   $extent = substr($old_image, strpos($old_image, ".") + 1); 
   $pro_img = $name.'_profile.' . pathinfo($_FILES['pro_img']['name'],PATHINFO_EXTENSION);
   $pro_img = filter_var($pro_img, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['pro_img']['size'];
   $image_tmp_name = $_FILES['pro_img']['tmp_name'];
   $image_folder = 'uploaded_img/profiles/'.$pro_img;

   $allowed = array('png', 'jpg', 'jpeg', 'webp', 'JPG');
   $ext = pathinfo($pro_img, PATHINFO_EXTENSION);

   if (!in_array($ext, $allowed)) {
      $warning_msg[] = 'Only png, jpg, jpeg and webp are allowed!';
   }else{
      if(!empty($pro_img)){
         if($_FILES['pro_img']['size'] > 2000000){
            $warning_msg[] = 'File size is too large!';
         }else{
            if($pro_img == $name.'_profile.'){
               $new_img = $name.'_profile.'.$extent;
               $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE name = ?");
               $update_image ->execute([$new_img, $name]);
               rename('uploaded_img/profiles/'.$old_image,'uploaded_img/profiles/'.$new_img);
            }else{
               $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE name = ?");
               $update_image ->execute([$pro_img, $name]);
               unlink('uploaded_img/profiles/'.$old_image);
               move_uploaded_file($image_tmp_name, $image_folder);
               $success_msg[] = 'Image updated successfully!';
            }
   
         }
      }
   }

}

if(isset($_POST['add_pic'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   
   $pro_img = $name.'_profile.' . pathinfo($_FILES['pro_img']['name'],PATHINFO_EXTENSION);
   $pro_img = filter_var($pro_img, FILTER_SANITIZE_STRING);
   $image_tmp_name = $_FILES['pro_img']['tmp_name'];
   $image_folder = 'uploaded_img/profiles/'.$pro_img;

   $allowed = array('png', 'jpg', 'jpeg', 'webp', 'JPG');
   $ext = pathinfo($pro_img, PATHINFO_EXTENSION);

   if (!in_array($ext, $allowed)) {
      $warning_msg[] = 'Only png, jpg, jpeg and webp are allowed!';
   }else{
      if($_FILES['pro_img']['size'] > 2000000){
         $warning_msg[] = 'File size is too large!';
      }else{
         $insert_pro = $conn->prepare("UPDATE `users` SET image = ? WHERE email = ?");
         $insert_pro->execute([$pro_img, $email]);
               
         move_uploaded_file($image_tmp_name, $image_folder);
         $success_msg[] = 'Profile Picture added!';
      }
   }
}

if(isset($_POST['update_pass'])){

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $warning_msg[] = 'please enter old password!';
   }elseif($old_pass != $prev_pass){
      $warning_msg[] = 'old password not matched!';
   }elseif($new_pass != $cpass){
      $warning_msg[] = 'confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $success_msg[] = 'Password Updated Successfully!';
      }else{
         $info_msg[] = 'Please Enter a New Password!';
      }
   }
   
}

?>