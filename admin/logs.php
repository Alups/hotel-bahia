<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   $success_messdel[] = "Removed";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Logs</title>

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

<section class="contacts">

<h1 class="heading">Logs</h1>

<?php
if($fetch_profile['role'] == "staff"){
?>

<div class="box-container">
    <?php
    $selec_logs = $conn->prepare("SELECT * FROM `logs` WHERE role = 'staff'");
    $selec_logs->execute();
    $result_logs = $selec_logs->fetchAll();
    ?>

    <form name='frmSearch' action='' method='post'>
        <table id="messtableid" class='table table-striped align-middle caption-top'>
            <thead class="thd">
                <tr>
                    <th scope="col" class='table-header' width="10%">User</th>
                    <th scope="col" class='table-header' width="25%">Date & Time</th>
                    <th scope="col" class='table-header' width="20%">Event</th>
                    <th scope="col" class='table-header' width="40%">Log</th>
                    <th scope="col" class='table-header' width="10%">Action</th>
                </tr>
            </thead>
            <tbody id='table-body'>
                <?php
                if (!empty($result_logs)) { // Corrected variable name
                    foreach ($result_logs as $row) { // Corrected variable name
                        $dt = $row['date'];
                ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo date('m/d/Y h:i A', strtotime($dt)); ?></td>
                            <td><?php echo $row['event']; ?></td>
                            <td class="text-truncate" style="max-width: 100px;"><?php echo $row['log']; ?></td>
                            <td>
                                <a href="#viewlog_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-eye"></i></a>
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

   <?php }else{ ?>
      <div class="box-container">
    <?php
    $selec_logs = $conn->prepare("SELECT * FROM `logs` WHERE role = 'admin'");
    $selec_logs->execute();
    $result_logs = $selec_logs->fetchAll();
    ?>

    <form name='frmSearch' action='' method='post'>
        <table id="messtableid" class='table table-striped align-middle caption-top'>
            <thead class="thd">
                <tr>
                    <th scope="col" class='table-header' width="10%">User</th>
                    <th scope="col" class='table-header' width="25%">Date & Time</th>
                    <th scope="col" class='table-header' width="20%">Event</th>
                    <th scope="col" class='table-header' width="40%">Log</th>
                    <th scope="col" class='table-header' width="10%">Action</th>
                </tr>
            </thead>
            <tbody id='table-body'>
                <?php
                if (!empty($result_logs)) { // Corrected variable name
                    foreach ($result_logs as $row) { // Corrected variable name
                        $dt = $row['date'];
                ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo date('m/d/Y h:i A', strtotime($dt)); ?></td>
                            <td><?php echo $row['event']; ?></td>
                            <td class="text-truncate" style="max-width: 100px;"><?php echo $row['log']; ?></td>
                            <td>
                                <a href="#viewlog_<?php echo $row['id']; ?>" class="option-btn" data-bs-toggle="modal"><i class="fas fa-eye"></i></a>
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

   <?php } ?>
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
    $('#messtableid').DataTable({
      order: [[1, "desc"]],
    });
   });

   if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

</script>

<?php include '../components/alers.php'; ?>
   
</body>
</html>