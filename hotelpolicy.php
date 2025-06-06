<?php
session_start();

include('includes/db.php');

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
 }else{
	$user_id = '';
 };
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
							<li class="menu__item"><a href="about.php" class="menu__link ">About</a></li>
							<li class="menu__item"><a href="#rooms" class="menu__link">Rooms</a></li>
							<li class="menu__item"><a href="#contact" class="menu__link scroll">Contact Us</a></li>
							<li class="menu__item"><a href="logout.php" class="menu__link">Logout</a></li>
							<?php 
							}else{ 
							?>			

	
						</ul>
                        <ul class="nav navbar-nav menu__list">
							<li class="menu__item1"><a href="index.php" class="menu__link1">Home</a></li>
							<li class="menu__item1"><a href="about.php" class="menu__link1 ">About</a></li>
							<li class="menu__item1"><a href="#rooms" class="menu__link">Rooms</a></li>
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

	




<section class="hotel-policies">
    <h3>Hotel Policies</h3>
    <h4>Children and Extra Beds:</h4>
    <p>Extra beds are dependent on the room you choose. Please check the individual room capacity for more details.</p>
    <p>All children are welcome.</p>
    <ul>
   <li class="policy-item">Infant (0-2 years): Stay for free if using existing bedding. Baby cot/crib may be requested directly from the property.</li>
    <li class="policy-item">Children (3-10 years): Stay for free if using existing bedding. If you need an extra bed, it will incur an additional charge.</li>
    <li class="policy-item">Guests 11 years and older are considered as adults. Must use an extra bed which will incur an additional charge.</li>
    </ul>

    <h4>Others:</h4>
    <p>When booking more than 5 rooms, different policies and additional supplements may apply.</p>

    <h4>Check-in/Check-out:</h4>
    <p>Check-in from: 02:00 PM</p>
    <p>Check-out until: 12:00 PM</p>

    <h4>Getting Around:</h4>
    <p>Distance from city center: 0.5 km</p>

    <h4>Extras:</h4>
    <p>Breakfast charge (unless included in room price): 200 PHP</p>
    <p>Daily Internet/Wi-Fi fee: 0 PHP</p>

    <h4>The Property:</h4>
    <p>License Id / Local Tax ID/ Entity Name: 213 399 849 000</p>
    <p>Non-smoking rooms/floors: Yes</p>
    <p>Number of bars/lounges: 1</p>
    <p>Number of floors: 1</p>
    <p>Number of restaurants: 1</p>
    <p>Number of rooms: 20</p>
    <p>Room voltage: 220</p>
    <p>Year property opened: 2001</p>
    <p>Most recent renovation: 2014</p>

    <h4>Parking:</h4>
    <p>Daily parking fee: 0 PHP</p>
</section>







	
	
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
                    
                    
                    <input type="submit" name="sub" value="Send Now" class="btn btn-primary">	
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
<script src="/library/bootstrap-5/bootstrap.bundle.min.js"></script>
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


