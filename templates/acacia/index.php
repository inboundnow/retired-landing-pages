<?php
/**
* Template Name: Acacia
* @package  WordPress Landing Pages
* @author   Inbound Template Generator
*/

/* Declare Template Key */
$key = lp_get_parent_directory(dirname(__FILE__));
$path = LANDINGPAGES_UPLOADS_URLPATH ."$key/";
$url = plugins_url();
/* Define Landing Pages's custom pre-load hook for 3rd party plugin integration */
do_action('wp_head');
$post_id = get_the_ID(); ?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>  <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>  <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> <!<![endif]-->

  <head>
	<!--  Define page title -->
    <title><?php wp_title(); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="LandingSumo.com">
    <link rel="icon" href="assets/img/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link href="assets/css/style.css" rel="stylesheet">


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>

	<!-- Load Normal WordPress wp_head() function -->
    <?php wp_head(); ?>

    <!-- Load Landing Pages's custom pre-load hook for 3rd party plugin integration -->
    <?php do_action("lp_head"); ?>
  </head>

  <body>

	  <?php
/* Start acacia_template_body Flexible Content Area Output */
	if(function_exists('have_rows')) :
		if(have_rows('acacia_template_body')) :
			 while(have_rows('acacia_template_body')) : the_row();
				 switch(get_row_layout()) :
				/* start layout hero_box */
				 case 'hero_box' : 
					$hero_bg_color = get_sub_field("hero_bg_color");
					$add_media = get_sub_field("add_media");
					$hero_image = get_sub_field("hero_image");
					$hero_video = get_sub_field("hero_video");
					$hero_headline = get_sub_field("hero_headline");
					$hero_headline_color = get_sub_field("hero_headline_color");
					$hero_subh_eadline = get_sub_field("hero_subh_eadline");
					$hero_sub_headline_color = get_sub_field("hero_sub_headline_color");
					$hero_button_text = get_sub_field("hero_button_text");
					$hero_button_text_color = get_sub_field("hero_button_text_color");
					$hero_button_link = get_sub_field("hero_button_link");
					$hero_button_bg_color = get_sub_field("hero_button_bg_color");
					$hero_media = ($add_media == 'image') ? $hero_image_url : $hero_video;
					?>
					<div id="is" style="background-color:<?php echo $hero_bg_color; ?>">
						<div class="container">
							<div class="row">
								<div class="col-lg-6 col-md-6 centered">
									<img src="<?php echo $hero_media;  ?>" style="max-height:600px;" alt="">
								</div>
								<div class="col-lg-6 col-md-6 centered" style="">
									<h1 style="color:<?php echo $hero_headline_color; ?>"><?php echo $hero_headline;  ?></h1>
									<p style="color:<?php echo $hero_sub_headline_color; ?>"><?php echo $hero_sub_headline;  ?></p>
									<button class="btn btn-lg btn-green mtb">Get Our App For Free</button>
								</div>
							</div><!--/row -->
						</div><!--/container -->
					</div><!-- /.IS Wrap -->
    
    <div class="container">
    	<div class="row mtb centered">
    		<h2>What Is Our App?</h2>
    		<div class="icons-white-bg mt">
				<div class="col-md-4">
					<i class="fa fa-lightbulb-o"></i>
					<p>Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
				</div><!--/col-md-4 -->
				
				<div class="col-md-4">
					<i class="fa fa-globe"></i>
					<p>Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
				</div><!--/col-md-4 -->
				
				<div class="col-md-4">
					<i class="fa fa-laptop"></i>
					<p>Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
				</div><!--/col-md-4 -->
    		</div><!--/icons-white-bg -->
    
    	</div><!--/row -->
    </div><!--/container -->
    
    <div id="gs">
    	<div class="container">
			<div class="row mtb">
				<div class="col-md-7 centered">
					<img src="assets/img/tablet.png" alt="" class="img-responsive">
				</div><!--/col-md-7 -->
				
				<div class="col-md-5">
					<h2 class="mb">Enjoy Your Devices</h2>
					<p>Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur. Donec id elit non mi porta.</p>
					<p>Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
					<p>Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas. Ut non enim eleifend felis pretium feugiat. Vivamus quis mi. Dummy text of the printing and typesetting.</p>
					<button class="btn btn-lg btn-green mt">Register Now!</button> <button class="btn btn-lg btn-blue mt">Learn More</button>
				</div><!--/col-md-5 -->
				
			</div><!--/row -->
    	</div>
    </div><!--/Grey Section end -->
    
    <div id="mint" class="carousel slide" data-ride="carousel">
    	<div class="col-md-6 col-md-offset-3">
		    <!-- Carousel
		    ================================================== -->
		      <!-- Indicators -->
		      <ol class="carousel-indicators">
		        <li data-target="#mint" data-slide-to="0" class="active"></li>
		        <li data-target="#mint" data-slide-to="1"></li>
		        <li data-target="#mint" data-slide-to="2"></li>
		      </ol>
		      <div class="carousel-inner">
		        <div class="item active">
		        	<div class="centered mtb">
		            	<img src="assets/img/pic01.jpg" class="img-circle" height="100" width="100" alt="First slide">
				        <h4>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</h4>
				        <p>SHARON SMITH</p>
					</div>
				</div><!-- /item -->
				
		        <div class="item">
		        	<div class="centered mtb">
		            	<img src="assets/img/pic02.jpg" class="img-circle" height="100" width="100" alt="First slide">
				        <h4>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</h4>
				        <p>SAM MANNING</p>
					</div>
				</div><!-- /item -->

		        <div class="item">
		        	<div class="centered mtb">
		            	<img src="assets/img/pic03.jpg" class="img-circle" height="100" width="100" alt="First slide">
				        <h4>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</h4>
				        <p>PAUL STEVENSON</p>
					</div>
				</div><!-- /item -->
	    	
			</div><!--/carousel-inner -->
    	</div><!--/col-md-6 -->
    </div><!--/mint -->
    
    
    <div class="container">
    	<div class="row mtb">
    		<h2 class="centered">Frequently Asked Questions</h2>
    		
    		<div class="col-md-6 mt">
    			<h4>Dummy text of the printing</h4>
    			<p>Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas. Ut non enim eleifend felis pretium feugiat. Vivamus quis mi. Dummy text of the printing and typesetting.</p>
    			<h4 class="mt">Mellentesque habitant morbi </h4>
    			<p>Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
    		</div><!--/col-md-6 -->
    		
    		<div class="col-md-6 mt">
    			<h4>Dummy text of the printing</h4>
    			<p>Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas. Ut non enim eleifend felis pretium feugiat. Vivamus quis mi. Dummy text of the printing and typesetting.</p>
    			<h4 class="mt">Mellentesque habitant morbi </h4>
    			<p>Dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since, when an unknown ristique senectus et netus.</p>
    		</div>
    		<div class="centered mtb">
    			<button class="btn btn-lg btn-green mt">More Questions?</button>
    		</div><!--/col-md-6 -->
    	
    	</div><!--/row -->
    </div><!-- /container -->
    
    <div id="f">
    	<div class="container">
    		<div class="row centered mtb">
    			<h2>Get In Touch With Us</h2>
    			<h5>Mellentesque habitant morbi tristique senectus et netus<br/> et malesuada famesac turpis egestas.</h5>
    			<div class="col-md-6 col-md-offset-3 mt">
					<form role="form" action="register.php" method="post" enctype="plain"> 
	    				<input type="email" name="email" class="subscribe-input" placeholder="Enter your e-mail address..." required>
						<button class='btn btn-green2 subscribe-submit' type="submit">Subscribe</button>
					</form>
    			</div><!--/col-md-6 -->
    		</div><!--/row -->
    		<div class="col-md-6 col-md-offset-3">
    			<div class="social-icons">
    				<a href="#"><i class="fa fa-dribbble"></i></a>
    				<a href="#"><i class="fa fa-instagram"></i></a>
    				<a href="#"><i class="fa fa-twitter"></i></a>
    			</div>
    		</div>
    	</div><!--/container -->
    </div><!--/f -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/retina-1.1.0.js"></script>
  </body>
</html>
