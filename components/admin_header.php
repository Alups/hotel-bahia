<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header" id="header">
<?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img class="mainlogo" src="../images/logo.png" alt=""/> 
         <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
         </div>

        <div class="profile">
         <p>Hello <?= $fetch_profile['name']; ?>!</p>
         <a href="../admin/update_profile.php?id=<?= $fetch_profile['id']; ?>" class="btn">update profile</a> 
         <button type="button" class="btn-logout" data-bs-toggle="modal" data-bs-target="#logout" data-bs-whatever="<?php  echo $row['id'];?>">logout</button>
      </div>

      <div class="modal expand" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content">
            <img src="../images/warning.png" class="img-fluid rounded mx-auto d-block" alt="">
            <div class="modal-body text-center border-0">
            <h1>Are you sure you want to logout?</h1>
            </div>
            <div class="modal-footer justify-content-center text-center border-0">
            <button  class="btnm btn-delete-cancel" data-bs-dismiss="modal">Cancel</button>
            <a id="links" class="btnm btn-delete-yes">Yes</a>
            </div>
         </div>
      </div>
      </div>
      <!-- <i class="fa-duotone fa-list"></i> -->

    </header>
    <div class="l-navbar" id="nav-bar">
      <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <nav class="nav">
                <div class="nav_list"> 
                  <a href="dashboard.php" class="nav_link active"> <i class='bx bx-bar-chart-square nav_icon'></i> <span class="nav_name">Dashboard</span> </a> 
                  <a href="reserve.php" class="nav_link"> <i style="padding-left: 5px" class='fa-solid fa-calendar nav_icon'></i> <span class="nav_name">Walkins</span> </a> 
                  <a href="bookings.php" class="nav_link"> <i style="padding-left: 5px" class='fa-solid fa-bookmark nav_icon'></i> <span class="nav_name">Booking</span> </a> 
                  <a href="booking_list.php" class="nav_link"> <i class='fa-solid fa-list nav_icon'></i> <span class="nav_name">Booking History</span> </a> 
                  <a href="rooms.php" class="nav_link"> <i class='bx bx-box nav_icon'></i> <span class="nav_name">Rooms</span> </a> 
                  <a href="categories.php" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Category</span> </a>
                  
                  <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name dropdown-toggle">Accounts</span> </a> 
                  <div class="collapse" id="collapseExample">
                     <a href="admin_accounts.php" class="nav_link"> <i class='bx bx-user-circle nav_icon'></i> <span class="nav_name">Admin</span> </a>
                     <a href="users_accounts.php" class="nav_link"> <i class='bx bx-universal-access nav_icon'></i> <span class="nav_name">Users</span> </a>
                     <!-- <a href="deactive_accounts.php" class="nav_link"> <i class='bx bx-user-x nav_icon'></i> <span class="nav_name">Inactive Users</span> </a> -->
                  </div>
               
                  <a href="messages.php" class="nav_link"> <i class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">Feedback</span> </a>
                  <a href="logs.php" class="nav_link"> <i class="bx bx-notepad nav_icon"></i> <span class="nav_name">Logs</span> </a> 
            </div>
        </nav>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.js" integrity="sha512-6DC1eE3AWg1bgitkoaRM1lhY98PxbMIbhgYCGV107aZlyzzvaWCW1nJW2vDuYQm06hXrW0As6OGKcIaAVWnHJw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="../library/bootstrap-5/bootstrap.bundle.min.js"></script>
<script src="../library/moment.min.js"></script>
<script src="../library/daterangepicker.min.js"></script>
<script src="../library/Chart.bundle.min.js"></script>
<script src="../library/jquery.dataTables.min.js"></script>
<script src="../library/dataTables.bootstrap5.min.js"></script>

<script type='text/javascript'>
   var exampleModal = document.getElementById('logout')
   exampleModal.addEventListener('show.bs.modal', function (event) {
   var button = event.relatedTarget
   document.getElementById("links").setAttribute("href","../components/admin_logout.php");
   })

   document.addEventListener("DOMContentLoaded", function(event) {
      
   const showNavbar = (toggleId, navId, bodyId, headerId) =>{
   const toggle = document.getElementById(toggleId),
   nav = document.getElementById(navId),
   bodypd = document.getElementById(bodyId),
   headerpd = document.getElementById(headerId)

   // Validate that all variables exist
   if(toggle && nav && bodypd && headerpd){
         toggle.addEventListener('click', ()=>{
         // show navbar
         nav.classList.toggle('show')
         // change icon
         toggle.classList.toggle('bx-x')
         // add padding to body
         bodypd.classList.toggle('body-pd')
         // add padding to header
         headerpd.classList.toggle('body-pd')
         })
      }
   }

   showNavbar('header-toggle','nav-bar','body-pd','header')

   /*===== LINK ACTIVE =====*/
   const linkColor = document.querySelectorAll('.nav_link')

   function colorLink(){
   if(linkColor){
   linkColor.forEach(l=> l.classList.remove('active'))
   this.classList.add('active')
   }
   }
   linkColor.forEach(l=> l.addEventListener('click', colorLink))

   // Your code to run since DOM is loaded and ready
   });
</script>
