<?php

if(isset($success_msg)){
   foreach($success_msg as $success_msg){
      echo '<script>swal("'.$success_msg.'", "", "success");</script>';
   }
}

if(isset($success_checkout)){
   foreach($success_checkout as $success_checkout){
      echo '<script>swal("'.$success_checkout.'", "", "success").then(function(){window.location = "orders.php"});</script>';
   }
}

if(isset($success_up)){
   foreach($success_up as $success_up){
      echo '<script>swal("'.$success_up.'", "", "success").then(function(){window.location = "categories.php"});</script>';
   }
}

if(isset($success_proddel)){
   foreach($success_proddel as $success_proddel){
      echo '<script>swal("'.$success_proddel.'", "", "success").then(function(){window.location = "products.php"});</script>';
   }
}

if(isset($success_catdel)){
   foreach($success_catdel as $success_catdel){
      echo '<script>swal("'.$success_catdel.'", "", "success").then(function(){window.location = "categories.php"});</script>';
   }
}

if(isset($success_orderdel)){
   foreach($success_orderdel as $success_orderdel){
      echo '<script>swal("'.$success_orderdel.'", "", "success").then(function(){window.location = "bookings.php"});</script>';
   }
}

if(isset($list_del)){
   foreach($list_del as $list_del){
      echo '<script>swal("'.$list_del.'", "", "success").then(function(){window.location = "booking_list.php"});</script>';
   }
}

if(isset($success_admindel)){
   foreach($success_admindel as $success_admindel){
      echo '<script>swal("'.$success_admindel.'", "", "success").then(function(){window.location = "admin_accounts.php"});</script>';
   }
}

if(isset($success_userdel)){
   foreach($success_userdel as $success_userdel){
      echo '<script>swal("'.$success_userdel.'", "", "success").then(function(){window.location = "users_accounts.php"});</script>';
   }
}

if(isset($success_messdel)){
   foreach($success_messdel as $success_messdel){
      echo '<script>swal("'.$success_messdel.'", "", "success").then(function(){window.location = "messages.php"});</script>';
   }
}

if(isset($success_register)){
   foreach($success_register as $success_register){
      echo '<script>swal("'.$success_register.'", "", "success").then(function(){window.location = "user_login.php"});</script>';
   }
}

if(isset($success_pass)){
   foreach($success_pass as $success_pass){
      echo '<script>swal("'.$success_pass.'", "", "success").then(function(){window.location = "user_login.php"});</script>';
   }
}

if(isset($success_batdel)){
   foreach($success_batdel as $success_batdel){
      echo '<script>swal("'.$success_batdel.'", "", "success").then(function(){window.location = "batch.php"});</script>';
   }
}

if(isset($success_restore)){
   foreach($success_restore as $success_restore){
      echo '<script>swal("'.$success_restore.'", "", "success").then(function(){window.location = "deactive_accounts.php"});</script>';
   }
}


if(isset($warning_msg)){
   foreach($warning_msg as $warning_msg){
      echo '<script>swal("'.$warning_msg.'", "", "warning");</script>';
   }
}

if(isset($info_msg)){
   foreach($info_msg as $info_msg){
      echo '<script>swal("'.$info_msg.'", "", "info");</script>';
   }
}

if(isset($error_msg)){
   foreach($error_msg as $error_msg){
      echo '<script>swal("'.$error_msg.'", "", "error");</script>';
   }
}

?>
