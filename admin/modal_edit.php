<div class="modal expand" id="edit_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-products">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-prod">

            <h1 class="heading">update room</h1>

            <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="pid" value="<?= $row['id']; ?>">
                <input type="hidden" name="old_name" value="<?= $row['name']; ?>">
                <input type="hidden" name="old_category" value="<?= $row['category']; ?>">
          
                <span>Room number <i class="notice">*</i></span>
                <input type="number" name="name" required class="box form-control" maxlength="100" placeholder="enter product name" value="<?= $row['name']; ?>">

                <select name="category" class="box form-control">
                <option selected disabled><?= $row['category']; ?></option>
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
              <div class="flex-btn">
                    <input type="submit" name="update" class="btn" value="update">
                </div>
            </form>
            </section>
         </div>
      </div>
</div>



<div class="modal expand" id="editstat_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-status">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-stat">


            <form action="" method="post">
                <input type="hidden" name="room_id" value="<?= $row['id']; ?>">
                <input type="hidden" name="room_number" value="<?= $row['name']; ?>">
                <select name="room_status" class="custom-select" >
                    <option selected disabled><?= $row['status']; ?></option>
                    <option value="Available">Available</option>
                    <option value="Occupied">Occupied</option>
                </select>
                <div class="flex-btn">
                <input type="submit" value="update" class="btn" name="update_room">
                </div>
            </form>

            </section>
         </div>
      </div>
</div>






<div class="modal expand" id="editstat1_<?php echo $row['booking_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-status">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-stat">


            <form action="" method="post" >
                <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
                <input type="hidden" name="book_id" value="<?= $row['id']; ?>">
                <input type="hidden" name="room_number" value="<?= $row['rooms']; ?>">
                <select name="payment_status" class="custom-select">
                    <option selected disabled><?= $row['payment_status']; ?></option>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                    <option value="Cancelled">Cancel</option>

                </select>
                <div class="flex-btn">
                <input type="submit" value="update" class="btn" name="update_payment">
                </div>
            </form>

            </section>
         </div>
      </div>
</div>


<div class="modal expand" id="editstat2_<?php echo $row['booking_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-status">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-stat">


            <form action="" method="post" >
                <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
                <input type="hidden" name="book_id" value="<?= $row['id']; ?>">
                <input type="hidden" name="method" value="<?= $row['method']; ?>">
                <select name="status" class="custom-select">
                    <option selected disabled><?= $row['status']; ?></option>
                    <option value="Arrival">Approve</option>
                    <option value="Pending">Pending</option>

                </select>
                <div class="flex-btn">
                <input type="submit" value="update" class="btn" name="update_stat">
                </div>
            </form>

            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="viewstat_<?php echo $row['booking_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content view-order">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="view-order">

            <div class="box">
            <h1 class="heading">view booking</h1>
                <!-- <p hidden ><?= $dt = $row['placed_on']; ?></p> -->
                <p>Booking id : <span><?= $row['booking_id']; ?></span></p>
                <p>Customer name : <span><?= $row['name']; ?></span> </p>
                <p>Number : <span><?= $row['number']; ?></span> </p>
                <p>Number of Adults : <span><?= $row['adults']; ?></span> </p>
                <p>Number of children : <span><?= $row['childs']; ?></span> </p>
                <p>Room type : <span><?= $row['category']; ?></span> </p>
                <p>Total price : <span>&#8369 <?= $row['price']; ?></span> </p>
                <p>Payment method : <span><?= $row['method']; ?></span> </p>
                <?php if($row['payment_status'] == "Delivered"){ ?>
                <p style="color: green;">Status: <?php echo $row['payment_status']; ?></p>
                <?php }elseif($row['payment_status'] == "On processed"){ ?>
                <p style="color: orange;">Status: <?php echo $row['payment_status']; ?></p>
                <?php }else{ ?>
                <p style="color: red;">Status: <?php echo $row['payment_status']; ?></p>
                <?php } ?>
            </div>

            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="viewpayment_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content view-order">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="view-order">

            <div class="box">
            <h1 class="heading">view Payment</h1>
            <img src="../uploaded_img/proof/<?= $row['proof']; ?>" alt="">
            </div>

            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="editcat_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-products">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-prod">

            <h1 class="heading">update category</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <input type="hidden" name="old_name" value="<?= $row['name']; ?>">
                <input type="hidden" name="old_price" value="<?= $row['price']; ?>">
                <input type="hidden" name="old_details" value="<?= $row['details']; ?>">
                <input type="hidden" name="old_cat_img" value="<?= $row['cat_img']; ?>">
                <div class="image-container">
                    <div class="main-image">
                        <img src="../uploaded_img/category_img/<?= $row['cat_img']; ?>" alt="">
                    </div>
                </div>
                <span>Name <i class="notice">*</i></span>
                <input type="text" name="name" required class="box" maxlength="100" placeholder="enter category name" value="<?= $row['name']; ?>">
                 <span>Name <i class="notice">*</i></span>
                <input type="number" name="price" required class="box" maxlength="100" placeholder="enter category price" value="<?= $row['price']; ?>">
                <span>Details <i class="notice">*</i></span>
                <textarea name="details" class="box form-control" required cols="30" rows="10"><?= $row['details']; ?></textarea>
                <span>Image <i class="notice">* file size must be 2MB below</i></span>
                <input type="file" name="cat_img" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" value="<?= $row['cat_img']; ?>">
                <div class="flex-btn">
                    <input type="submit" name="update" class="btn" value="update">
                </div>
            </form>

            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="editadmin_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-products">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-prod">

            <h1 class="heading">update Admin Account</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="role" value="<?= $row['role']; ?>">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <input type="hidden" name="prev_pass" value="<?= $row['password']; ?>">  
                <span>Username</span>
                <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $row['name']; ?>">
                <span>Role</span>
                <select name="role" class="box" required>
                    <?php if($row['role']=='admin'){
                        echo "<option selected disabled>Admin</option>";
                    }else{
                        echo "<option selected disabled>Staff</option>";
                    }?>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
                <span>Old Password <i class="notice">*</i></span>
                <input type="password" name="old_pass" placeholder="Enter old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                <span>New Password <i class="notice">*</i></span>
                <input type="password" name="new_pass" placeholder="Enter new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                <span>Confirm Password <i class="notice">*</i></span>
                <input type="password" name="confirm_pass" placeholder="Confirm new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                <div class="flex-btn">
                    <input type="submit" value="update now" class="btn" name="update_admin">
                </div>
            </form>
            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="edituser_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-products">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-prod">

            <h1 class="heading">Update User Account</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <input type="hidden" name="prev_pass" value="<?= $row['password']; ?>">
                <span>Username</span>
                <input disabled type="text" name="name" required class="box" maxlength="100" placeholder="Enter username" value="<?= $row['name']; ?>">
                <span>Email</span>
                <input disabled type="text" name="email" required class="box" maxlength="100" placeholder="Enter email" value="<?= $row['email']; ?>">
                <span>Number</span>
                <input disabled ype="text" name="number" required class="box" maxlength="100" placeholder="Enter mobile number" value="<?= $row['number']; ?>">
                <span>New Password <i class="notice">*</i></span>
                <input type="password" name="new_pass" placeholder="Enter new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                <span>Confirm Password <i class="notice">*</i></span>
                <input type="password" name="confirm_pass" placeholder="Confirm new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                <div class="flex-btn">
                    <input type="submit" value="update now" class="btn" name="update_user">
                </div>
            </form>
            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="viewuser_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content view-order">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="view-order">

            <div class="box">
            <h1 class="heading">view user</h1>
                <p> Username : <span><?= $row['name']; ?></span> </p>
                <p> Number : <span><?= $row['number']; ?></span> </p>
                <p> Email : <span><?= $row['email']; ?></span> </p>
            </div>

            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="viewmessage_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content view-order">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="view-order">

            <div class="box">
            <h1 class="heading">view feedback</h1>
                <p> Username : <span><?= $row['name']; ?></span> </p>
                <p> Number : <span><?= $row['number']; ?></span> </p>
                <p> Email : <span><?= $row['email']; ?></span> </p>
                <p> feedback : <span class="text-break"><?= $row['message']; ?></span></p>
            </div>

            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="viewlog_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content view-order">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="view-order">

            <div class="box">
            <h1 class="heading">view log</h1>
                <p hidden ><?= $dt = $row['date']; ?></p>
                <p> Username : <span><?= $row['username']; ?></span> </p>
                <p> Date and Time : <span><?= date('m/d/Y h:i:A', strtotime($dt)); ?></span> </p>
                <p> Event : <span><?= $row['event']; ?></span> </p>
                <p> Log : <span class="text-break"><?= $row['log']; ?></span></p>
            </div>

            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="editallt_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-products">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-prod">

            <h1 class="heading">update Fee</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id']; ?>"> 
                <input type="hidden" name="old_city" value="<?= $row['city_name']; ?>"> 
                <input type="hidden" name="old_street" value="<?= $row['street_name']; ?>">
                <div class="inputBox">
                  <span>Select City <i class="notice">*</i></span>
                     <select name="city" class="box">
                     <option selected disabled value="<?php echo $row['city_name']?>"><?php echo $row['city_name']?></option>';
                     <?php
                        $select_city = $conn->prepare("SELECT * FROM `cities`");
                        $select_city->execute();
                        if($select_city->rowCount() > 0){
                           while($fetch_city = $select_city->fetch(PDO::FETCH_ASSOC)){
                              echo '<option value="'.$fetch_city['city_name'].'">'.$fetch_city['city_name'].'</option>';
                           }}else{
                              echo '<span>No city</span>';   }
                     ?>
                     </select>
                  </div>
                  <div class="inputBox">
                  <span>Select Street <i class="notice">*</i></span>
                     <select name="street" class="box">
                     <option selected disabled value="<?php echo $row['street_name']?>"><?php echo $row['street_name']?></option>';
                     <?php
                        $select_street = $conn->prepare("SELECT * FROM `streets`");
                        $select_street->execute();
                        if($select_street->rowCount() > 0){
                           while($fetch_street = $select_street->fetch(PDO::FETCH_ASSOC)){
                              echo '<option value="'.$fetch_street['street_name'].'">'.$fetch_street['street_name'].'</option>';
                           }}else{
                              echo '<span>No city</span>';   }
                     ?>
                     </select>
                  </div>
                <span>Delivery Fee <i class="notice">*</i></span>
                <input type="number" name="fee" placeholder="Enter delivery fee" maxlength="20"  class="box" value="<?php echo $row['deliv_fee']; ?>">
                <div class="flex-btn">
                    <input type="submit" value="update now" class="btn" name="update_all">
                </div>
            </form>
            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="editcity_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-products">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-prod">

            <h1 class="heading">update city</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id']; ?>"> 
                <input type="hidden" name="old_city" value="<?= $row['city_name']; ?>"> 
                <span>City Name <i class="notice">*</i></span>
                <input type="text" name="city" placeholder="Enter city name" maxlength="20"  class="box" value="<?php echo $row['city_name']; ?>">
                <div class="flex-btn">
                    <input type="submit" value="update now" class="btn" name="update_city">
                </div>
            </form>
            </section>
         </div>
      </div>
</div>

<div class="modal expand" id="editstreet_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-products">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <section class="update-prod">

            <h1 class="heading">update Street</h1>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row['id']; ?>"> 
                <input type="hidden" name="old_street" value="<?= $row['street_name']; ?>">
                <input type="hidden" name="old_city" value="<?= $row['city_name']; ?>"> 
                <div class="inputBox">
                  <span>Select City <i class="notice">*</i></span>
                     <select name="city" class="box">
                     <option selected disabled value="<?php echo $row['city_name']?>"><?php echo $row['city_name']?></option>';
                     <?php
                        $select_city = $conn->prepare("SELECT * FROM `cities`");
                        $select_city->execute();
                        if($select_city->rowCount() > 0){
                           while($fetch_city = $select_city->fetch(PDO::FETCH_ASSOC)){
                              echo '<option value="'.$fetch_city['city_name'].'">'.$fetch_city['city_name'].'</option>';
                           }}else{
                              echo '<span>No city</span>';   }
                     ?>
                     </select>
                  </div>
                <span>Street Name <i class="notice">*</i></span>
                <input type="text" name="street" placeholder="Enter street name" maxlength="50"  class="box" value="<?php echo $row['street_name']; ?>">
                <div class="flex-btn">
                    <input type="submit" value="update now" class="btn" name="update_street">
                </div>
            </form>
            </section>
         </div>
      </div>
</div>


<div class="modal expand" id="assign_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
         <div class="modal-content update-status">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
            <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
            <input type="hidden" name="book_id" value="<?= $row['id']; ?>">
            <h3><?= $row['category'] ?> Available Rooms</h3>
            <div class="checkbox-container">
            <?php
            $select_room = $conn->prepare("SELECT * FROM `rooms` WHERE category = ? AND status = 'Available'");
            $select_room->execute([$row['category']]);

            if ($select_room->rowCount() > 0): ?>
                <?php while ($fetch_room = $select_room->fetch(PDO::FETCH_ASSOC)): ?>
                    <label>
                    <input name="rooms[]" type="checkbox" value="<?= $fetch_room['name'] ?>">
                    <?= $fetch_room['name'] ?><br>
                </label>
                <?php endwhile; ?>
                <input type="submit" class="btn" name="assign" value="Submit">
            <?php else: ?>
                <span>No room</span>
            <?php endif; ?>
            </div>
            
            
        </form>  
            </div>
      </div>
</div>