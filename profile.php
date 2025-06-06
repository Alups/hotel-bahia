<?php
session_start();

include('includes/db.php');

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
 }else{
	$user_id = '';
 };

 if(isset($_POST['update'])){

	$id = $_POST['id'];
	$id = filter_var($id, FILTER_SANITIZE_STRING);
	$name = $_POST['name'];
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	$lname = $_POST['lname'];
	$lname = filter_var($lname, FILTER_SANITIZE_STRING);
	$email = $_POST['email'];
	$email = filter_var($email, FILTER_SANITIZE_STRING);
	$number = $_POST['number'];
	$number = filter_var($number, FILTER_SANITIZE_STRING);
	
	
 
	$update_profile_name = $conn->prepare("UPDATE `users` SET name = ?, last_name = ?, email = ?, number = ? WHERE id = ?");
	$update_profile_name->execute([$name, $lname, $email, $number, $id]);

	$success_msg[] = 'updated successfully!';

 }


 if(isset($_POST['update_pass'])) {
    $id = $_POST['id'];
	$prev_pass = trim($_POST['prev_pass']);
	$old_pass = trim(sha1($_POST['old_pass']));
	
    $new_pass = sha1($_POST['new_pass']);
    $confirm_pass = sha1($_POST['confirm_pass']);

    // Validate and sanitize input

 
        if ($new_pass !== sha1("")) {
            // Perform database update using prepared statement
            try {
                $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_admin_pass->execute([$new_pass, $id]);
                $success_msg[] = 'Password updated successfully!';
            } catch (PDOException $e) {
                $error_msg[] = 'An error occurred while updating password: ' . $e->getMessage();
            }
        } else {
            $info_msg[] = 'Please enter a new password!';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hotel Bahia Subic</title>
    <link rel="icon" type="image/png"  href="images/small-logo.png">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-qHjXDMEJ/Kslljz+OzJovVFJ2pmxOmT+5eZlP6OfIUl1qVjKQH0TlElm67t6hHFw" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<body>
	<section class="py-5 my-5">
		<div class="container">
			<h1 class="mb-5">Account Settings</h1>
			<div class="bg-white shadow rounded-lg d-block d-sm-flex">
				<div class="profile-tab-nav border-right">
				<?php

				if (isset($_SESSION['user_id'])) {
					$user_id = $_SESSION['user_id'];

					// Query to fetch the logged-in user from the "users" table using the correct column name
					$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
					$select_user->execute([$user_id]);

					// Check if the user is found
					if ($select_user->rowCount() > 0) {
						$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

						// Now you can access the logged-in user's details in $fetch_user array
						// For example:

						// Display the user name and email or use them as needed
						?>
						<div class="p-4">
							<h4 class="text-center"><?php echo $fetch_user['name'] . ' ' . $fetch_user['last_name']; ?></h4>
						</div>
						<?php
					} else {
						// If the logged-in user is not found, handle the situation accordingly
						echo "<p>Logged-in user not found!</p>";
					}
				} else {
					// If the user is not logged in, handle the situation accordingly
					echo "<p>User not logged in!</p>";
				}
			?>
			
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
							<i class="fa fa-home text-center mr-1"></i> 
							Account
						</a>
						<a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
							<i class="fa fa-key text-center mr-1"></i> 
							Password
						</a>
						<a class="nav-link" id="bookings-tab" data-toggle="pill" href="#mybookings" role="tab" aria-controls="notification" aria-selected="false">
							<i class="fa fa-book text-center mr-1"></i> 
							My Bookings
						</a>
						<a class="nav-link" href="index.php">
						<i class="fa fa-arrow-left text-center mr-1"></i> 
						Back
						</a>
					</div>
				</div>
				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
			
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
					<form action="" method="post">
						<h3 class="mb-4">Account Settings</h3>
						<div class="row">
							<div class="col-md-6">
							<?php

							if (isset($_SESSION['user_id'])) {
								$user_id = $_SESSION['user_id'];

								// Query to fetch the logged-in user from the "users" table using the correct column name
								$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
								$select_user->execute([$user_id]);

								// Check if the user is found
								if ($select_user->rowCount() > 0) {
									$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

									// Now you can access the logged-in user's details in $fetch_user array
									// For example:

									// Display the user name and email or use them as needed
									?>
					
								<div class="form-group">
								  	<label>First Name</label>
									  <input hidden type="text" name="id" class="form-control" value="<?= $fetch_user['id']; ?>">
								  	<input type="text" name="name" class="form-control" value="<?= $fetch_user['name']; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Last Name</label>
								  	<input type="text" name="lname" class="form-control" value="<?= $fetch_user['last_name']; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Email</label>
								  	<input type="text" name="email" class="form-control" value="<?= $fetch_user['email']; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Phone number</label>
								  	<input type="text" name="number" class="form-control" value="<?= $fetch_user['number']; ?>">
								</div>
							</div>
							<?php
					} else {
						// If the logged-in user is not found, handle the situation accordingly
						echo "<p>Logged-in user not found!</p>";
					}
				} else {
					// If the user is not logged in, handle the situation accordingly
					echo "<p>User not logged in!</p>";
				}
			?>
						</div>
						<div>
							<button name="update" class="btn btn-primary">Update</button>
						</div>
			</form>
					</div>

					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
					<form action="" method="post">
						<h3 class="mb-4">Password Settings</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<input hidden type="hidden" name="id" class="form-control" value="<?= $fetch_user['id']; ?>">
									  <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
									  <input type="hidden" name="old_pass" placeholder="enter old password" maxlength="20"  class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  	<label>New password</label>
									  <input type="password" name="new_pass" placeholder="enter new password" maxlength="20"  class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>Confirm new password</label>
									  <input type="password" name="confirm_pass" placeholder="confirm new password" maxlength="20"  class="form-control" oninput="this.value = this.value.replace(/\s/g, '')">
								</div>
							</div>
						</div>
						<div>
							<button name="update_pass" class="btn btn-primary">Update</button>
						</div>
					</form>
					</div>
				
					
					<div class="tab-pane fade" id="mybookings" role="tabpanel" aria-labelledby="notification-tab">
						<h3 class="mb-4">Booking Lists</h3>
						<div class="form-group">
						<?php
						$select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ?");
						$select_bookings->execute([$user_id]);


						
						if ($select_bookings->rowCount() > 0) {
							while ($fetch_booking = $select_bookings->fetch(PDO::FETCH_ASSOC)) {
								?>
								<div class="booking-container"> <!-- Add the booking container here -->
									<div class="form-check">
										<label class="form-check-label" for="notification1">
											<p>Booking id : <span><?= $fetch_booking['booking_id']; ?></span></p>
											<p>Name : <span><?= $fetch_booking['name']; ?></span></p>
											<p>Email : <span><?= $fetch_booking['email']; ?></span></p>
											<p>Number : <span><?= $fetch_booking['number']; ?></span></p>
											<p>Check in : <span><?= $fetch_booking['check_in']; ?></span></p>
											<p>Check out : <span><?= $fetch_booking['check_out']; ?></span></p>
											<p>Rooms : <span><?= $fetch_booking['rooms']; ?></span></p>
											<p>Adults : <span><?= $fetch_booking['adults']; ?></span></p>
											<p>Children : <span><?= $fetch_booking['childs']; ?></span></p>
											<p>Status : <span style="color: <?= ($fetch_booking['status'] === 'Approved') ? 'green' : 'red'; ?>"><?= $fetch_booking['status']; ?></span></p>
										</label>
										<div>
										<button class="cancel-button" data-booking-id="<?= $fetch_booking['booking_id']; ?>">Cancel</button>
										</div>
									</div>
								</div> <!-- End of booking container -->
						<?php
							}
						} else {
							?>
							<div class="box" style="text-align: center;">
								<p style="padding-bottom: .5rem; text-transform: capitalize;">no bookings found!</p>
								<a href="index.php#rooms" class="btn1">book new</a>
							</div>
						<?php
						}
						?>
					</div>

						
					</div>
				</div>
			</div>
		</div>
	</section>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<?php include 'components/alers.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const cancelButton = document.getElementById('cancelButton');

        cancelButton.addEventListener('click', function () {
            window.location.href = 'index.php';
        });
        });

    </script>
</body>
</html>