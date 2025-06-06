<?php
session_start();

include('includes/db.php');

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
 }else{
	$user_id = '';
 };

 if(isset($_POST['send'])){

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
 
	if($select_message->rowCount() > 0){
	   $info_msg[] = 'Already sent message!';
	}else{
 
	   $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
	   $insert_message->execute([$user_id, $name, $email, $number, $msg]);
 
	   $success_msg[] = 'Message sent successfully!';
 
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
							<li class="menu__item"><a href="index.php" class="menu__link">Home</a></li>
							<li class="menu__item"><a href="#about" class="menu__link scroll">About</a></li>
							<!-- <li class="menu__item"><a href="#gallery" class="menu__link scroll">Gallery</a></li> -->
							<!-- <li class="menu__item"><a href="index.php" class="menu__link">Rooms</a></li> -->
							<li class="menu__item"><a href="#contact" class="menu__link scroll">Contact Us</a></li>
							<li class="menu__item"><a href="logout.php" class="menu__link">Logout</a></li>
							<?php 
							}else{ 
							?>			

	
						</ul>

                        <ul class="nav navbar-nav menu__list">
					    	<li class="menu__item1"><a href="index.php" class="menu__link1">Home</a></li>
							<li class="menu__item1"><a href="#about" class="menu__link1 scroll">About</a></li>
							<!-- <li class="menu__item"><a href="#gallery" class="menu__link scroll">Gallery</a></li> -->
							<!-- <li class="menu__item"><a href="index.php" class="menu__link">Rooms</a></li> -->
							<li class="menu__item1"><a href="#contact" class="menu__link1 scroll">Contact Us</a></li>
		                	<li class="menu__item1"><a href="login.php" class="menu__link1">Login</a></li>
			 <?php
            }
         ?> 
						</ul>
					</nav>
				</div>
			</nav>

		</div>
	</div>


<!--//Header-->


			<div class="clearfix"> </div>
</div>

<!-- /about -->
 	<div class="about-wthree" id="about">
		  <div class="container">
				   <div class="ab-w3l-spa">
                            <h3 class="title-w3-agileits title-black-wthree">About Us</h3> 
						   <p class="about-para-w3ls">Hotel Bahia is a luxury hotel located in a stunning waterfront location in a beautiful coastal city. Our hotel prides itself on offering world-class accommodations, exceptional service, and a memorable experience for our guests. With a rich history spanning several decades, Hotel Bahia has become synonymous with elegance, sophistication, and a warm hospitality.

Our hotel features a range of well-appointed rooms and suites, each designed with comfort and style in mind. Whether you're traveling for business or leisure, we have accommodations to suit your needs. Our rooms offer modern amenities such as flat-screen TVs, complimentary Wi-Fi, plush bedding, and private bathrooms.

Guests at Hotel Bahia can indulge in a variety of dining options. We have multiple restaurants and bars that serve a diverse selection of cuisine, from local specialties to international dishes prepared by our talented chefs. Whether you're in the mood for a fine dining experience or a casual meal by the water, we have something to satisfy every palate.</p>
						   <!-- <img src="images/all/IMG_20210815_205518.jpg" class="img-responsive" alt="Hair Salon"> -->
						   <hr>
						   <p class="about-para-w3ls" > In addition to our exceptional accommodations and dining options, Hotel Bahia boasts a range of facilities and services to enhance your stay. We have a fully equipped fitness center, a rejuvenating spa, and a sparkling swimming pool where guests can relax and unwind. Our hotel also offers event spaces and conference rooms, making it an ideal choice for business meetings, weddings, and social gatherings.

At Hotel Bahia, we strive to provide personalized service and ensure that every guest has a memorable and enjoyable stay. Our friendly and attentive staff are always ready to assist with any requests or inquiries you may have, ensuring a seamless and stress-free experience.

Whether you're visiting for a weekend getaway, a business trip, or a special occasion, Hotel Bahia is committed to exceeding your expectations and creating lasting memories. We look forward to welcoming you to our hotel and providing you with an unforgettable experience.</p>
		          </div>
		   	<div class="clearfix"> </div>
    </div>
</div>
 	<!-- //about -->
     <section class="contact-w3ls" id="contact">
	<div class="container">
		<div class="col-lg-6 col-md-6 col-sm-6 contact-w3-agile2" data-aos="flip-left">
			<div class="contact-agileits">
				<h4>Contact Us</h4>
				<p class="contact-agile2">Sign Up For Our News Letters</p>
				<form  method="post" name="sentMessage" id="contactForm" >
					<div class="control-group form-group">
                        
                            <label class="contact-p1">Full Name:</label>
                            <input type="text" class="form-control" name="name" id="name" required >
                            <p class="help-block"></p>
                       
                    </div>	
                    <div class="control-group form-group">
                        
                            <label class="contact-p1">Phone Number:</label>
                            <input type="tel" class="form-control" name="phone" id="phone" required >
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
				<?php
				if(isset($_POST['sub']))
				{
					$name =$_POST['name'];
					$phone = $_POST['phone'];
					$email = $_POST['email'];
					$approval = "Not Allowed";
					$sql = "INSERT INTO `contact`(`fullname`, `phoneno`, `email`,`cdate`,`approval`) VALUES ('$name','$phone','$email',now(),'$approval')" ;

					if(mysqli_query($con,$sql))
					echo"OK";

				}
				?>
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
</body>
</html>


