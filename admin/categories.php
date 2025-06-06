<?php

include '../components/connect.php';

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

if(isset($_POST['add_category'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);

   
   $cat_img = $name.'_cat.' . pathinfo($_FILES['cat_img']['name'],PATHINFO_EXTENSION);
   $cat_img = filter_var($cat_img, FILTER_SANITIZE_STRING);
   $image_tmp_name = $_FILES['cat_img']['tmp_name'];
   $image_folder = '../uploaded_img/category_img/'.$cat_img;

   $allowed = array('png', 'jpg', 'jpeg', 'webp', 'JPG');
   $ext = pathinfo($cat_img, PATHINFO_EXTENSION);

   $select_cat = $conn->prepare("SELECT * FROM `category` WHERE name = ?");
   $select_cat->execute([$name]);

   if($select_cat->rowCount() > 0){
      $warning_msg[] = 'Category name already exist!';
   }else{

         if (!in_array($ext, $allowed)) {
            $warning_msg[] = 'Only png, jpg, jpeg and webp are allowed!';
         }else{
            if($_FILES['cat_img']['size'] > 2000000){
               $warning_msg[] = 'Image size is too large!';
            }else{

               $insert_category = $conn->prepare("INSERT INTO `category`(name, price, details,cat_img) VALUES(?,?,?,?)");
               $insert_category->execute([$name, $price, $details, $cat_img]);
               
               move_uploaded_file($image_tmp_name, $image_folder);

               $event = 'Add new category';
               $log = 'Added new category '.$name;
            
               $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
               $logDat->execute([$uname, $event, $log]);

               $success_msg[] = 'New category added!';
            }
         }
   }  

};

if(isset($_POST['update'])){

   $id = $_POST['id'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);

   
   $old_details = $_POST['old_details'];
   $old_name = $_POST['old_name'];

   $update_cat = $conn->prepare("UPDATE `category` SET name = ?, details = ?, price = ? WHERE id = ?");
   $update_cat->execute([$name, $details, $price, $id]);
   $success_up[] = 'Category name updated successfully!';

   $old_image = $_POST['old_cat_img'];
   $extent = substr($old_image, strpos($old_image, ".") + 1); 
   $cat_img = $name.'_cat.' . pathinfo($_FILES['cat_img']['name'],PATHINFO_EXTENSION);
   $cat_img = filter_var($cat_img, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['cat_img']['size'];
   $image_tmp_name = $_FILES['cat_img']['tmp_name'];
   $image_folder = '../uploaded_img/category_img/'.$cat_img;

   $allowed = array('png', 'jpg', 'jpeg', 'webp', 'JPG');
   $ext = pathinfo($cat_img, PATHINFO_EXTENSION);

   if (!in_array($ext, $allowed)) {
      $warning_msg[] = 'Only png, jpg, jpeg and webp are allowed!';
   }else{
      if(!empty($cat_img)){
         if($_FILES['cat_img']['size'] > 2000000){
            $warning_msg[] = 'image size is too large!';
         }else{
            if($cat_img == $name.'_cat.'){
               $new_img = $name.'_cat.'.$extent;
               $update_image = $conn->prepare("UPDATE `category` SET cat_img = ? WHERE id = ?");
               $update_image ->execute([$new_img, $id]);
               rename('../uploaded_img/category_img/'.$old_image,'../uploaded_img/category_img/'.$new_img);
            }else{
               $update_image = $conn->prepare("UPDATE `category` SET cat_img = ? WHERE id = ?");
               $update_image ->execute([$cat_img, $id]);
               unlink('../uploaded_img/category_img/'.$old_image);
               move_uploaded_file($image_tmp_name, $image_folder);

               $success_up[] = 'Image updated successfully!';
            }

         }
      }
   }

   if($name == $old_name){
      $event = 'Update Category';
      $log = 'Updated the Category image of '.$name;

      $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
      $logDat->execute([$uname, $event, $log]);
     
   }elseif($name != $old_name && $cat_img != $old_image){
      $event = 'Update Category';
      $log = 'Updated the Category '.$name;

      $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
      $logDat->execute([$uname, $event, $log]);
   }else{
      $event = 'Update Category';
      $log = 'Updated the Category name of '.$name;

      $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
      $logDat->execute([$uname, $event, $log]);
   }
   
}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $name = $_GET['name'];

   $delete_category_image = $conn->prepare("SELECT * FROM `category` WHERE id = ?");
   $delete_category_image->execute([$delete_id]);
   $fetch_delete_image = $delete_category_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/category_img/'.$fetch_delete_image['cat_img']);
   $delete_category = $conn->prepare("DELETE FROM `category` WHERE id = ?");
   $delete_category->execute([$delete_id]);

   $event = 'Remove Category';
   $log = 'Removed the Category name of '.$name;

   $logDat = $conn->prepare("INSERT INTO `logs`(username, role, event, log) VALUES(?,?,?,?)");
   $logDat->execute([$uname, $role, $event, $log]);

   $success_catdel[] = 'Removed';
  
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

   <h1 class="heading">ROOM TYPES<button class="btns"><i class="fas fa-plus-square" href="#myModal1" ></i></button></h1>

   <!-- The Modal -->
   <div id="myModal1" class="modal">

   <!-- Modal content -->
   <div class="modal-content">
      <span class="close">&times;</span>
         <section class="add-products">

         <h1 class="heading">add category</h1>

         <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate >
            <div class="flex">
               <div class="inputBox">
                  <span>Category name <i class="notice">*</i></span>
                  <input type="text" class="box form-control" required maxlength="100" placeholder="Enter category name" name="name">
               </div>
               <div class="inputBox">
                  <span>Category Price <i class="notice">*</i></span>
                  <input type="number" min="0" class="box form-control" required max="9999999999" placeholder="Enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
               </div>
               <div class="inputBox">
               <span>Room details <i class="notice">*</i></span>
                     <textarea name="details" placeholder="Enter Room details" class="box form-control" required maxlength="500" cols="30" rows="10"></textarea>
               </div>
            <div class="inputBox">
                  <span>Image <i class="notice">* file size must be 2MB below</i></span>
                  <input type="file" name="cat_img" accept="image/jpg, image/jpeg, image/png, image/webp" class="box form-control" required>
            </div>
            </div>
            <input type="submit" value="add category" class="btn" name="add_category">
         </form>
      </section>
   </div>

   </div>

   <div class="box-container">
         <?php	
         $select_product = $conn->prepare("SELECT * FROM `category`");
         $select_product->execute();
         $result = $select_product->fetchAll();
      ?>
      <form name='frmSearch' action='' method='post'>
      <table id="cattableid" class='table table-striped align-middle caption-top'>
      <thead class="thd">
         <tr>
         <th scope="col" class='table-header' width="40%">Category Image</th>
         <th scope="col" class='table-header' width="40%">Category Name</th>
         <th scope="col" class='table-header' width="40%">Category Price</th>
         <th scope="col" class='table-header' width="20%">Action</th>
         </tr>
      </thead>
      <tbody id='table-body'>
         <?php
         if(!empty($result)) { 
            foreach($result as $row) {
         ?>
         <tr>
            <td><img src="../uploaded_img/category_img/<?= $row['cat_img']; ?>" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>₱<?= number_format($row['price'], 0, '.', ',') ?>.00</td>

            <td>
            <!-- <a href="#view_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-eye"></i></a> -->
            <a href="#editcat_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-edit"></i></a>
            <button type="button" class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?php  echo $row['id'].'&name='.$row['name'];?>"><i class="fas fa-trash-alt"></i></button>
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
            <h1>Are you sure you want to remove this category?</h1>
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

</body>
</html>
