<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
};

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


if(isset($_POST['update_room'])){
   $room_id = $_POST['room_id'];
   $room_status = $_POST['room_status'];
   $room_number = $_POST['room_number'];
   $room_status = filter_var($room_status, FILTER_SANITIZE_STRING);
   $update_status = $conn->prepare("UPDATE `rooms` SET status = ? WHERE id = ?");
   $update_status->execute([$room_status, $room_id]);

   
   $event = 'Update Room Status';
   $log = 'Updated room no.'.$room_number.' to '.$room_status;

   $logDat = $conn->prepare("INSERT INTO `logs`(username, role, event, log) VALUES(?,?,?,?)");
   $logDat->execute([$uname, $role, $event, $log]);

   $success_msg[] = 'Room status has been updated!';
}


if (isset($_POST['update'])) {
    $pid = $_POST['pid'];
    $newName = $_POST['name'];
    $category = $_POST['category'];
    $oldName = $_POST['old_name'];
    $oldCategory = $_POST['old_category'];

    // Update the room in the database
    $updateRoom = $conn->prepare("UPDATE `rooms` SET `name` = ?, `category` = ? WHERE `id` = ?");
    $updateRoom->execute([$newName, $category, $pid]);

    $event = 'update room';
    $log = 'updated room '.$newName;

    $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
    $logDat->execute([$uname, $event, $log]);

    // Check if the room update was successful
    if ($updateRoom->rowCount() > 0) {
        // Room updated successfully
        $successMsg[] = 'Room updated successfully!';
    } else {
        // Room update failed
        $errorMsg[] = 'Failed to update room. Please try again.';
    }


}



if(isset($_POST['add_room'])){
   
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);




   // $image_01 = $name.'_img1.' . pathinfo($_FILES['image_01']['name'],PATHINFO_EXTENSION);
   // $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   // $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   // $image_folder_01 = '../uploaded_img/'.$image_01;

   // $image_02 = $name.'_img2.' . pathinfo($_FILES['image_02']['name'],PATHINFO_EXTENSION);
   // $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   // $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   // $image_folder_02 = '../uploaded_img/'.$image_02;

   // $image_03 = $name.'_img3.' . pathinfo($_FILES['image_03']['name'],PATHINFO_EXTENSION);
   // $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   // $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   // $image_folder_03 = '../uploaded_img/'.$image_03;

   $select_rooms= $conn->prepare("SELECT * FROM `rooms` WHERE name = ?");
   $select_rooms->execute([$name]);

   if($select_rooms->rowCount() > 0){
      $warning_msg[] = 'Room name already exist!';
   }else{

            $insert_products = $conn->prepare("INSERT INTO `rooms`(name, category,status) VALUES(?,?,'Available')");
            $insert_products->execute([$name, $category]);

            
            
            // move_uploaded_file($image_tmp_name_01, $image_folder_01);
            // move_uploaded_file($image_tmp_name_02, $image_folder_02);
            // move_uploaded_file($image_tmp_name_03, $image_folder_03);

            $event = 'Add Room';
            $log = 'Added new room '.$name;
        
            $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
            $logDat->execute([$uname, $event, $log]);

            $success_msg[] = 'New Room added!';
         }
      }
     ;


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $name = $_GET['name'];

   $delete_product_image = $conn->prepare("SELECT * FROM `rooms` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   // unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   // unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   // unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `rooms` WHERE id = ?");
   $delete_product->execute([$delete_id]);


   $event = 'Remove room';
   $log = 'Removed room '.$name;
        
   $logDat = $conn->prepare("INSERT INTO `logs`(username, role, event, log) VALUES(?,?,?,?)");
   $logDat->execute([$uname, $role, $event, $log]);

   $success_roomdel[] = 'Removed';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Rooms</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

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

</script>
<?php include '../components/admin_header.php'; ?>

<section class="show-products">

   <h1 class="heading">Add Rooms <button class="btns"><i class="fa fa-bed" style="color: blue;" href="#myModal1" ></i></button></h1>


   <!-- The Modal -->
   <div id="myModal1" class="modal">

   <!-- Modal content -->
   <div class="modal-content">
      <span class="close">&times;</span>
         <section class="add-products">

         <h1 class="heading">add room</h1>

         <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="flex">
               <div class="inputBox">
                  <span>Room No. <i class="notice">*</i></span>
                  <input type="number" class="box form-control" required maxlength="100" placeholder="Enter room number" name="name">
               </div>
               <!-- <div class="inputBox">
                  <span>Room price <i class="notice">*</i></span>
                  <input type="number" min="0" class="box form-control" required max="9999999999" placeholder="Enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
               </div> -->
               <!-- <div class="inputBox">
                  <span>Product stock <i class="notice">*</i></span>
                  <input type="number" min="0" class="box form-control" required max="9999999999" placeholder="Enter product stock" onkeypress="if(this.value.length == 10) return false;" name="stock">
               </div> -->
               <div class="inputBox">
                  <span>Room category <i class="notice">*</i></span>
                  <select name="category" class="box form-control" required>
                     <?php
                        $select_cat = $conn->prepare("SELECT * FROM `category`");
                        $select_cat->execute();
                        if($select_cat->rowCount() > 0){
                           while($fetch_cat = $select_cat->fetch(PDO::FETCH_ASSOC)){ 

                           echo '<option value="'.$fetch_cat['name'].'">'.$fetch_cat['name'].'</option>';

                           }}else{
                              echo '<span>No category</span>';
                           }
                     ?>
                  </select>
                </div>
               <!-- <div class="inputBox">
                     <span>Image 01 <i class="notice">* file size must be 2MB below</i></span>
                     <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box form-control" required>
               </div> -->
          <!-- <div class="inputBox">
                     <span>Image 02 <i class="notice">* file size must be 2MB below</i></span>
                     <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box form-control" required>
               </div>
               <div class="inputBox">
                     <span>Image 03 <i class="notice">* file size must be 2MB below</i></span>
                     <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box form-control" required>
               </div>      -->
               
               </div>
            
            <input type="submit" value="add room" class="btn" name="add_room">
         </form>

      </section>
   </div>
   </div>


   <div class="box-container">
         <?php	
         $select_product = $conn->prepare("SELECT * FROM `rooms`");
         $select_product->execute();
         $result = $select_product->fetchAll();
         ?>
      <form name='frmSearch' action='' method='post'>
      <table id="prodtableid" class='table table-striped align-middle caption-top'>
      <thead class="thd">
         <tr>
         <!-- <th scope="col" class='table-header' width="10%">Room ID</th> -->
         <!-- <th scope="col" class='table-header' width="20%">Room Image</th> -->
         <th scope="col" class='table-header' width="20%">Room No.</th>
         <!-- <th scope="col" class='table-header' width="20%">Price</th> -->
         <th scope="col" class='table-header' width="20%">Category</th>
         <th scope="col" class='table-header' width="20%">Assigned Date</th>
         <th scope="col" class='table-header' width="10%">Status</th>
        <!-- <th scope="col" class='table-header' width="10%">Stocks</th> -->
         <th scope="col" class='table-header' width="10%">Action</th>
         </tr>
      </thead>
      <tbody id='table-body'>
         <?php
         if(!empty($result)) { 
            foreach($result as $row) {

               $select_room = $conn->prepare("SELECT * FROM `rooms` WHERE id = ?");
               $select_room->execute([$row['id']]);
               $rs = $select_room->fetchAll();


         ?>
         <tr>
            <!-- <td><?php echo $row['id']; ?></td> -->
            <!-- <td><img src="../uploaded_img/<?= $row['image_01']; ?>" alt=""></td> -->
            <td style="padding-left: 50px;"><?php echo $row['name']; ?></td>
            <!-- <td>₱<?php echo $row['price']; ?></td> -->
            </td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['assigned_date']; ?></td>

            <?php if($row['status'] == "Available"){ ?>
               <td style="color: green;"><a href="#editstat_<?php echo $row['id']; ?>" class="aa" data-bs-toggle="modal"><?php echo $row['status']; ?></td></a>
               <?php }else{ ?>
                  <td style="color: red;"><a href="#editstat_<?php echo $row['id']; ?>" class="a" data-bs-toggle="modal"><?php echo $row['status']; ?></td></a>
            <?php } ?>
          
            <td>
            <!-- <a href="#editstat_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-edit"></i></a> -->

            <!-- <a href="#view_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-eye"></i></a> -->
            <a href="#edit_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-edit"></i></a>
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

      <div class="modal expand" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content">
            <img src="../images/warning.png" class="img-fluid rounded mx-auto d-block" alt="">
            <div class="modal-body text-center border-0">
            <h1>Are you sure you want to remove this item?</h1>
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

      $.fn.dataTable.ext.search.push(
      function( settings, searchData, index, rowData, counter ) {
      
         var restock = $('input:checkbox[name="restock"]:checked').map(function() {
         return this.value;
         }).get();
      

         if (restock.length === 0) {
         return true;
         }
         
         if (restock.indexOf(searchData[5]) !== -1) {
         return true;
         }
         
         return false;
      }
   );

   var table = $('#prodtableid').DataTable();

   $('input:checkbox').on('change', function () {
      table.draw();
   });

   });

   var exampleModal = document.getElementById('deleteModal')
   exampleModal.addEventListener('show.bs.modal', function (event) {
   // Button that triggered the modal
   var button = event.relatedTarget
   // Extract info from data-bs-* attributes
   var idkoto = button.getAttribute('data-bs-whatever')
   // If necessary, you could initiate an AJAX request here
   document.getElementById("link").setAttribute("href","rooms.php?delete=" + idkoto);
   })

   if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>

<?php include '../components/alers.php'; ?>

</body>
</html>
