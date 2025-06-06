<?php
session_start();

include('includes/db.php');

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
 }else{
	$user_id = '';
 };


 
if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if ($select_message->rowCount() > 0) {
        $info_msg[] = 'Already sent a message!';
    } else {

        $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
        $insert_message->execute([$user_id, $name, $email, $number, $msg]);

        // Set the success message in a JavaScript variable
		$success_msg[] = 'Message sent';
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Hotel Bahia Subic</title>
<link rel="icon" type="image/png"  href="images/small-logo.png">

<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Resort Inn Responsive , Smartphone Compatible web template , Samsung, LG, Sony Ericsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/font-awesome.css" rel="stylesheet"> 
<link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen">
<link href="css/easy-responsive-tabs.css" rel='stylesheet' type='text/css'/>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" property="" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="manifest" href="manifest.json"/>

<script type="text/javascript" src="js/modernizr-2.6.2.min.js"></script>
<!--fonts-->
<link href="//fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Federo" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<!--//fonts-->
</head>
<body>

<div class="banner-top">
	<div class="clearfix"></div>
</div>
	<div class="w3_navigation">
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="navbar-header navbar-left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<h1><a class="navbar-brand" href="index.php">Hotel <span>Bahia</span><p class="logo_w3l_agile_caption">Subic</p></a></h1>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
             
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
        <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
					<nav class="menu menu--iris">
                        
						<ul class="nav navbar-nav menu__list">
							<li class="menu__item"><a href="" class="menu__link">Home</a></li>
							<li class="menu__item"><a href="about.php" class="menu__link ">About</a></li>
					
							<li class="menu__item"><a href="#contact" class="menu__link scroll">Contact Us</a></li>
							<li class="menu__item"><a href="profile.php" class="menu__link">Profile</a></li>
							<li class="menu__item"><a href="logout.php" class="menu__link">Logout</a></li>
							<?php 
							}else{ 
							?>			

	
						</ul>

                        <ul class="nav navbar-nav menu__list">
							<li class="menu__item1"><a href="" class="menu__link1">Home</a></li>
							<li class="menu__item1"><a href="about.php" class="menu__link1 ">About</a></li>
							<!-- <li class="menu__item1"><a href="#gallery" class="menu__link1 scroll">Gallery</a></li> -->
							<!-- <li class="menu__item1"><a href="#rooms" class="menu__link1 scroll">Rooms</a></li> -->
							<li class="menu__item1"><a href="#contact" class="menu__link1 scroll">Contact Us</a></li>
							<li class="menu__item1"><a href="login.php" class="menu__link1">Profile</a></li>

		                	<li class="menu__item1"><a href="login.php" class="menu__link1 ">Login</a></li>
			 <?php
            }
         ?> 
						</ul>
					</nav>
				</div>
			</nav>

		</div>
	</div>

	<div id="home" class="w3ls-banner">
		<!-- banner-text -->
		<div class="slider">
			<div class="callbacks_container">
				<ul class="rslides callbacks callbacks1" id="slider4">
					<li>
						<div class="w3layouts-banner-top">

							<div class="container">
								<div class="agileits-banner-info">
								<h4>Hotel <span>Bahia</h4>
									<h3>We know what you love</h3>
										<p>Welcome to our hotels</p>
									<!-- <div class="agileits_w3layouts_more menu__item">
										<a href="#" class="menu__link" data-toggle="modal" data-target="#myModal">Learn More</a>
									</div> -->
								</div>	
							</div>
						</div>
					</li>
					<li>
						<div class="w3layouts-banner-top w3layouts-banner-top1">
							<div class="container">
								<div class="agileits-banner-info">
								<h4>Hotel <span>Bahia</h4>
									<h3>Stay with friends & families</h3>
										<p>Come & enjoy precious moment with us</p>
									<!-- <div class="agileits_w3layouts_more menu__item">
										<a href="#" class="menu__link" data-toggle="modal" data-target="#myModal">Learn More</a>
									</div> -->
								</div>	
							</div>
						</div>
					</li>
					<li>
						<div class="w3layouts-banner-top w3layouts-banner-top2">
							<div class="container">
								<div class="agileits-banner-info">
								<h4>Hotel <span>Bahia</h4>
								<h3>want luxurious vacation?</h3>
									<p>Get accommodation today</p>
									<!-- <div class="agileits_w3layouts_more menu__item">
										<a href="#" class="menu__link" data-toggle="modal" data-target="#myModal">Learn More</a>
									</div> -->
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="clearfix"> </div>
			<!--banner Slider starts Here-->
		</div>
		    <div class="thim-click-to-bottom">
				<a href="#about" class="scroll">
					<i class="fa fa-long-arrow-down" aria-hidden="true"></i>
				</a>
			</div>
	</div>	
	<!-- //banner --> 
<!--//Header-->

	<div id="availability-agileits">
<div class="col-md-12 book-form-left-w3layouts">
	<a href="#rooms" class="menu__link1 scroll"><h2>ROOM RESERVATION</h2></a>
<!-- <li class="menu__item1"><a href="#rooms" class="menu__link1 scroll">Rooms</a></li> -->

</div>

			<div class="clearfix"> </div>
</div>
<!-- banner-bottom -->
	<div class="banner-bottom">
		<div class="container">	
			<div class="agileits_banner_bottom">
				<h3><span>Experience a good stay, enjoy fantastic offers</span> Find our friendly welcoming reception</h3>
			</div>
			<div class="w3ls_banner_bottom_grids">
				<ul class="cbp-ig-grid">
		
					<li>
						<div class="w3_grid_effect">
						<span class="cbp-ig-icon w3_road"></span>
							<h4 class="cbp-ig-title">MASTER BEDROOM</h4>
							<span class="cbp-ig-category">Hotel <span>Bahia</span>						
						</div>
					</li>
					<li>
						<div class="w3_grid_effect">
							<span class="cbp-ig-icon w3_cube"></span>
							<h4 class="cbp-ig-title">SEA SIDE VIEW</h4>
							<span class="cbp-ig-category">Hotel <span>Bahia</span>						
						</div>
					</li>
					<li>
						<div class="w3_grid_effect">
							<span class="cbp-ig-icon w3_users"></span>
							<h4 class="cbp-ig-title">BEST RESTAURANT</h4>
							<span class="cbp-ig-category">Hotel <span>Bahia</span>				
						</div>
					</li>
					<li>
						<div class="w3_grid_effect">
							<span class="cbp-ig-icon w3_ticket"></span>
							<h4 class="cbp-ig-title">WIFI COVERAGE</h4>
							<span class="cbp-ig-category">Hotel <span>Bahia</span>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
<!-- //banner-bottom -->
<!-- /about -->
 	<!-- //about -->
<!--sevices-->
<div class="advantages">
	<div class="container">
		<div class="advantages-main">
				<h3 class="title-w3-agileits">Other Services</h3>
		   	<div class="advantage-bottom">
				<!-- <div class="col-md-6 advantage-grid left-w3ls wow bounceInLeft" data-wow-delay="0.3s">
			 		<div class="advantage-block ">
						<i class="fa fa-credit-card" aria-hidden="true"></i>
			 			<h4>Stay First, Pay After! </h4>
						 <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. "</p>
						<p><i class="fa fa-check" aria-hidden="true"></i>Decorated room, proper air conditioned</p>
						<p><i class="fa fa-check" aria-hidden="true"></i>Private balcony</p>
			 		</div>
				</div> -->
			 	<!-- <div class="col-md-6 advantage-grid right-w3ls wow zoomIn" data-wow-delay="0.3s">
			 		<div class="advantage-block">
						<i class="fa fa-clock-o" aria-hidden="true"></i>
			 			<h4>24 Hour Restaurant</h4>
						 <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. "</p>						<p><i class="fa fa-check" aria-hidden="true"></i>24 hours room service</p>
						<p><i class="fa fa-check" aria-hidden="true"></i>24-hour Concierge service</p>
			 		</div>
			 	</div> -->
				<div class="col-md-6 advantage-grid right-w3ls wow zoomIn" data-wow-delay="0.3s">
			 		<div class="advantage-block">
			 			<h4>Live Band</h4>
						 <p>"Everynight there is a live band in our restaurant in front of our lobby where the guest can enjoy the atmosphere of hotel with music "</p>					
						<p><i class="fa fa-check" aria-hidden="true"></i>Listen to musicians while eating on our restaurant</p>
						<p><i class="fa fa-check" aria-hidden="true"></i>Enjoy the view of beach from our restaurant</p>
						<p><i class="fa fa-check" aria-hidden="true"></i>Best food will be serve with excellent service from our dining crew</p>
			 		</div>
			 	</div>
				 <div class="col-md-6 advantage-grid right-w3ls wow zoomIn" data-wow-delay="0.3s">
			 		<div class="advantage-block">
			 			<h4>Garden Cinema</h4>
						 <p>"Every friday night we will have a Movie night from our garden where the guests, or a walkin guest can watch an available movie."</p>				
							 	<p><i class="fa fa-check" aria-hidden="true"></i>Watch with your family</p>
						<p><i class="fa fa-check" aria-hidden="true"></i>A friendly ambiance from our garden</p>
						
						<p><i class="fa fa-check" aria-hidden="true"></i>Enjoy the movie and you can bring a food and eat to our picnic setup</p>
			 		</div>
			 	</div>
			<div class="clearfix"> </div>
			</div>
		</div>
	</div>
</div>

<!-- Gallery -->
<section class="portfolio-w3ls" id="gallery">
		 <h3 class="title-w3-agileits title-black-wthree">Our Gallery</h3>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g1.jpg" class="swipebox"><img src="images/gallery/g1.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g2.jpg" class="swipebox"><img src="images/gallery/g2.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g3.jpg" class="swipebox"><img src="images/gallery/g3.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g4.jpg" class="swipebox"><img src="images/gallery/g4.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g5.jpg" class="swipebox"><img src="images/gallery/g5.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
					</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g6.jpg" class="swipebox"><img src="images/gallery/g6.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
					   </div>
				   </a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g7.jpg" class="swipebox"><img src="images/gallery/g7.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
					   </div>
				   </a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g8.jpg" class="swipebox"><img src="images/gallery/g8.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
					   </div>
				   </a>
				</div>
					<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g9.jpg" class="swipebox"><img src="images/gallery/g9.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g10.jpg" class="swipebox"><img src="images/gallery/g10.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g11.jpg" class="swipebox"><img src="images/gallery/g11.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g12.jpg" class="swipebox"><img src="images/gallery/g12.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g13.jpg" class="swipebox"><img src="images/gallery/g13.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				<div class="col-md-3 gallery-grid gallery1">
					<a href="images/gallery/g14.jpg" class="swipebox"><img src="images/gallery/g14.jpg" class="img-responsive" alt="/">
						<div class="textbox">
						<h4>Hotel <span>Bahia</h4>
							<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
						</div>
				</a>
				</div>
				
				<div class="clearfix"> </div>
</section>
<!-- //gallery -->

<!-- faq -->

<section class="faqs" id="faq">

<h3 class="title-w3-agileits title-black-wthree">Frequently asked questions</h3>
<div class="row">

   <div class="image">
	  <img src="images/FAQs.gif" alt="">
   </div>

   <div class="content1">

	  <div class="box active">
		 <h3>what are payment methods?</h3>
		 <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam cupiditate mollitia.</p>
	  </div>

	  <div class="box">
		 <h3>what are payment methods?</h3>
		 <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam cupiditate mollitia.</p>
	  </div>

	  <div class="box">
		 <h3>what are payment methods?</h3>
		 <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam cupiditate mollitia.</p>
	  </div>

	  <div class="box">
		 <h3>what are payment methods?</h3>
		 <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam cupiditate mollitia.</p>
	  </div>

	  <div class="box">
		 <h3>what are payment methods?</h3>
		 <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam cupiditate mollitia.</p>
	  </div>

   </div>

</div>

</section>

<!-- end -->

<div id="availability-agileits">
<div class="col-md-12 book-form-left-w3layouts">
	<a href="hotelpolicy.php" target="blank_" class="menu__link1 "><h2>VIEW HOTEL POLICIES</h2></a>
<!-- <li class="menu__item1"><a href="#rooms" class="menu__link1 scroll">Rooms</a></li> -->

</div>

			<div class="clearfix"> </div>
</div>

	<div class="plans-section" id="rooms">
			<div class="container">
				 <h3 class="title-w3-agileits title-black-wthree">Rooms And Rates</h3>
						<div class="cbp-ig-grid1">
						<?php
							$select_room= $conn->prepare("SELECT * FROM `category`");
							$select_room->execute();
							if($select_room->rowCount() > 0){
								while($fetch_rooms = $select_room->fetch(PDO::FETCH_ASSOC)){ 
						?>		 
				<div class="col-md-3 price-grid ">
					<div class="price-block agile">
						<div class="price-gd-top">
						<img src="uploaded_img/category_img/<?= $fetch_rooms['cat_img']; ?>" height="250" alt="">
						<h4><?= $fetch_rooms['name']; ?></h4>
						</div>
						<div class="price-gd-bottom">
						<h4><?= $fetch_rooms['details']; ?></h4>
							<div class="price-selet">
								<h3>₱<?= number_format($fetch_rooms['price'], 0, '.', ',') ?></h3>
								<a href="rooms.php?id=<?= $fetch_rooms['id']; ?>"></i>Book now</a>
							</div>
						</div>
					</div>
				</div>
				<?php
         }
      }else{
         echo '<p class="empty">no rooms added yet!</p>';
      }
	  ?>
				
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>

<!-- contact -->
<section class="contact-w3ls" id="contact">
	<div class="container">
		<div class="col-lg-6 col-md-6 col-sm-6 contact-w3-agile2" data-aos="flip-left">
			<div class="contact-agileits">
				<h4>Contact Us</h4>
				<p class="contact-agile2">Send us a message</p>
				<form  method="post" name="sentMessage" id="contactForm" >
					<div class="control-group form-group">
                        
                            <label class="contact-p1">Full Name:</label>
                            <input type="text" class="form-control" name="name" id="name" required >
                            <p class="help-block"></p>
                       
                    </div>	
                    <div class="control-group form-group">
                        
                            <label class="contact-p1">Phone Number:</label>
                            <input type="number" class="form-control" oninput="this.value=this.value.slice(0,this.maxLength)" maxlength="11" name="number" id="phone" required >
							<p class="help-block"></p>
						
                    </div>
                    <div class="control-group form-group">
                        
                            <label class="contact-p1">Email Address:</label>
                            <input type="email" class="form-control" name="email" id="email" required >
							<p class="help-block"></p>
						
                    </div>
					<div class="control-group form-group">
                        
						<label class="contact-p1">Your message:</label>
						<input type="text" class="form-control" name="msg" id="msg" required >
						<p class="help-block"></p>
					
				</div>
                    
                    
                    <input type="submit" name="send" value="Send Now" class="btn btn-primary">	
				</form>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 contact-w3-agile1" data-aos="flip-right">
			<h4>Connect With Us</h4>
			<p class="contact-agile1"><strong>Phone :</strong>(047) 252 2894</p>
			<p class="contact-agile1"><strong>Email :</strong> <a>info@hotelbahiasubicbay.com</a></p>
			<p class="contact-agile1"><strong>Address :</strong>Bldg. 664 Waterfront Rd cor McKinley St, Subic Bay Freeport Zone, Olongapo, Philippines, 2222</p>
			<div class="social-bnr-agileits footer-icons-agileinfo">
				<ul class="social-icons3">
								<li><a href="https://www.facebook.com/hotelbahiasubicbay" class="fa fa-facebook icon-border facebook"> </a></li>
								<li><a href="#" class="fa fa-twitter icon-border twitter"> </a></li>
								<li><a href="#" class="fa fa-google-plus icon-border googleplus"> </a></li> 
							</ul>
			</div>
			<div style="width: 100%">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3857.0873817358624!2d120.27162408066799!3d14.820353134788705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396711493025b21%3A0x2b9ffce105989d99!2sHotel%20Bahia%20Subic%20Bay!5e0!3m2!1sen!2sph!4v1686727367941!5m2!1sen!2sph" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
		<div class="clearfix"></div>
	</div>
</section>

<!-- /contact -->
		
<!--/footer -->
<!-- js -->
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<!-- contact form -->
<script src="js/jqBootstrapValidation.js"></script>

<!-- /contact form -->	
<!-- Calendar -->
		<script src="js/jquery-ui.js"></script>
		<script>
				$(function() {
				$( "#datepicker,#datepicker1,#datepicker2,#datepicker3" ).datepicker();
				});
		</script>
<!-- //Calendar -->
<!-- gallery popup -->
<link rel="stylesheet" href="css/swipebox.css">
				<script src="js/jquery.swipebox.min.js"></script> 
					<script type="text/javascript">
						jQuery(function($) {
							$(".swipebox").swipebox();
						});
					</script>
<!-- //gallery popup -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
<!-- flexSlider -->
				<script defer src="js/jquery.flexslider.js"></script>
				<script type="text/javascript">
				$(window).load(function(){
				  $('.flexslider').flexslider({
					animation: "slide",
					start: function(slider){
					  $('body').removeClass('loading');
					}
				  });
				});
			  </script>
			<!-- //flexSlider -->
<script src="js/responsiveslides.min.js"></script>
			<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						  // Slideshow 4
						  $("#slider4").responsiveSlides({
							auto: true,
							pager:true,
							nav:false,
							speed: 500,
							namespace: "callbacks",
							before: function () {
							  $('.events').append("<li>before event fired.</li>");
							},
							after: function () {
							  $('.events').append("<li>after event fired.</li>");
							}
						  });
					
						});

						let accordions = document.querySelectorAll('.faqs .row .content1 .box');
						accordions.forEach(acco =>{
						acco.onclick = () =>{
							accordions.forEach(subAcco => {subAcco.classList.remove('active')});
							acco.classList.add('active');
						}
					})
			</script>
		<!--search-bar-->
		<script src="js/main.js"></script>	
<!--//search-bar-->
<!--tabs-->
<script src="js/easy-responsive-tabs.js"></script>
<script>
$(document).ready(function () {
$('#horizontalTab').easyResponsiveTabs({
type: 'default', //Types: default, vertical, accordion           
width: 'auto', //auto or any width like 600px
fit: true,   // 100% fit in a container
closed: 'accordion', // Start closed if in accordion view
activate: function(event) { // Callback function if tab is switched
var $tab = $(this);
var $info = $('#tabInfo');
var $name = $('span', $info);
$name.text($tab.text());
$info.show();
}
});
$('#verticalTab').easyResponsiveTabs({
type: 'vertical',
width: 'auto',
fit: true
});
});
</script>
<!--//tabs-->
<!-- smooth scrolling -->
	<script type="text/javascript">
		$(document).ready(function() {
		
			var defaults = {
			containerID: 'toTop', // fading element id
			containerHoverID: 'toTopHover', // fading element hover id
			scrollSpeed: 1200,
			easingType: 'linear' 
			};
										
		$().UItoTop({ easingType: 'easeOutQuart' });
		});
	</script>
	
	<div class="arr-w3ls">
	<a href="#home" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	</div>
<!-- //smooth scrolling -->
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'includes/alers.php' ?>
</body>
</html>


