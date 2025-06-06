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
							<li class="menu__item"><a href="#about" class="menu__link scroll">About</a></li>
							<li class="menu__item"><a href="#gallery" class="menu__link scroll">Gallery</a></li>
							<li class="menu__item"><a href="#rooms" class="menu__link scroll">Rooms</a></li>
							<li class="menu__item"><a href="#contact" class="menu__link scroll">Contact Us</a></li>
							<li class="menu__item"><a href="logout.php" class="menu__link">Logout</a></li>
							<?php 
							}else{ 
							?>			

	
						</ul>

                        <ul class="nav navbar-nav menu__list">
							<li class="menu__item1"><a href="" class="menu__link1">Home</a></li>
							<li class="menu__item1"><a href="#about" class="menu__link1 scroll">About</a></li>
							<li class="menu__item1"><a href="#gallery" class="menu__link1 scroll">Gallery</a></li>
							<li class="menu__item1"><a href="#rooms" class="menu__link1 scroll">Rooms</a></li>
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