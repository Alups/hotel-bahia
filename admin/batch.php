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

if(isset($_POST['add_batch'])){
   
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $stock = $_POST['stock'];
    $stock = filter_var($stock, FILTER_SANITIZE_STRING);

    $select_batch = $conn->prepare("SELECT MAX(batch_num) FROM `batch` WHERE pid = ?");
    $select_batch->execute([$pid]);
    $row = $select_batch->fetch(PDO::FETCH_ASSOC);

    $bnum =  implode($row);

    if(empty($bnum)){
        $insert_batch = $conn->prepare("INSERT INTO `batch`(pid, batch_price, batch_stock) VALUES(?,?,?)");
        $insert_batch->execute([$pid, $price, $stock]);
                
        $event = 'Add Product Batch';
        $log = 'Added new product batch on product ID: '.$pid;
            
        $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
        $logDat->execute([$uname, $event, $log]);

        $success_msg[] = 'New product batch added!';

    }else{
        $batch_num = $bnum + 1;
        $insert_batch = $conn->prepare("INSERT INTO `batch`(batch_num, pid, batch_price, batch_stock) VALUES(?,?,?,?)");
        $insert_batch->execute([$batch_num, $pid, $price, $stock]);
                
        $event = 'Add Product Batch';
        $log = 'Added new product batch on product ID: '.$pid;
            
        $logDat = $conn->prepare("INSERT INTO `logs`(username, event, log) VALUES(?,?,?)");
        $logDat->execute([$uname, $event, $log]);

        $success_msg[] = 'New product batch added!';
    }

    
};


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $name = $_GET['name'];

   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);

   $event = 'Remove Product Batch';
   $log = 'Removed product Batch '.$name;
        
   $logDat = $conn->prepare("INSERT INTO `logs`(username, role, event, log) VALUES(?,?,?,?)");
   $logDat->execute([$uname, $role, $event, $log]);


   $success_batchdel[] = 'Removed';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Product Batch</title>

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

</script>
<?php include '../components/admin_header.php'; ?>

<section class="show-products">

   <h1 class="heading">Product Batch List <button class="btns"><i class="fas fa-plus-square" href="#myModal1" ></i></button></h1>

   <!-- The Modal -->
   <div id="myModal1" class="modal">

   <!-- Modal content -->
   <div class="modal-content">
      <span class="close">&times;</span>
         <section class="add-products">

         <h1 class="heading">add batch product</h1>

         <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="flex">
               <div class="inputBox">
               <span>Select Product <i class="notice">*</i></span>
               <select name="pid" class="box form-control">
                     <?php
                        $select_prod = $conn->prepare("SELECT * FROM `products`");
                        $select_prod->execute();
                        if($select_prod->rowCount() > 0){
                           while($fetch_prod = $select_prod->fetch(PDO::FETCH_ASSOC)){
                              echo '<option value="'.$fetch_prod['id'].'">'.$fetch_prod['name'].'</option>';
                           }}else{
                              echo '<span>No product</span>';   }
                     ?>
                     </select>
               </div>
               <div class="inputBox">
                  <span>Product price <i class="notice">*</i></span>
                  <input type="number" min="0" class="box form-control" required max="9999999999" placeholder="Enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
               </div>
               <div class="inputBox">
                  <span>Product stock <i class="notice">*</i></span>
                  <input type="number" min="0" class="box form-control" required max="9999999999" placeholder="Enter product stock" onkeypress="if(this.value.length == 10) return false;" name="stock">
               </div>
            <input type="submit" value="add batch" class="btn" name="add_batch">
         </form>

      </section>
   </div>
   </div>


   <div class="box-container">
         <?php	
         $select_product = $conn->prepare("SELECT * FROM batch INNER JOIN products ON batch.pid = products.id");
         $select_product->execute();
         $result = $select_product->fetchAll();
      ?>
      <form name='frmSearch' action='' method='post'>
      <table id="prodtableid" class='table table-striped align-middle caption-top'>
      <thead class="thd">
         <tr>
         <th scope="col" class='table-header' width="40%">Product Name</th>
         <th scope="col" class='table-header' width="20%">Batch Number</th>
         <th scope="col" class='table-header' width="20%">Price</th>
         <th scope="col" class='table-header' width="10%">Stocks</th>
         <th scope="col" class='table-header' width="10%">Action</th>
         </tr>
      </thead>
      <tbody id='table-body'>
         <?php
         if(!empty($result)) { 
            foreach($result as $row) {
         ?>
         <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['batch_num']; ?></td>
            <td><span>&#8369</span><?php echo $row['batch_price']; ?></td>
            <?php if($row['batch_stock'] > 9){ ?>
               <td style="color: green;"><?php echo $row['batch_stock']; ?></td>
            <?php }elseif($row['stock'] == 0){ ?>
               <td style="color: red;"><?php echo $row['batch_stock']; ?></td>
            <?php }else{ ?>
               <td style="color: red;"><?php echo $row['batch_stock']; ?></td>
            <?php } ?>
            <td>
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
    $('#prodtableid').DataTable();
   });

   var exampleModal = document.getElementById('deleteModal')
   exampleModal.addEventListener('show.bs.modal', function (event) {
   // Button that triggered the modal
   var button = event.relatedTarget
   // Extract info from data-bs-* attributes
   var idkoto = button.getAttribute('data-bs-whatever')
   // If necessary, you could initiate an AJAX request here
   document.getElementById("link").setAttribute("href","products.php?delete=" + idkoto);
   })

   if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>

<?php include '../components/alers.php'; ?>

</body>
</html>
